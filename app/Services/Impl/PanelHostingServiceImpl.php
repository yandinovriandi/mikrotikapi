<?php

namespace App\Services\Impl;

use App\Services\PanelHostingInterface;

class PanelHostingServiceImpl implements PanelHostingInterface
{
    private $key = 'L4Fpq63NzldydPGYQr54Elqhrf6rq7XF';
    private $url = 'https://aapanel.mikrotikbot.com:8087';


    private function encrypt()
    {
        return [
            'request_token' => md5(time() . md5($this->key)),
            'request_time' => time(),
        ];
    }

    private function httpPostCookie($url, $data, $timeout = 60)
    {
        //Define where cookies are saved
        $cookie_file = './' . md5($this->url) . '.cookie';
        if (!file_exists($cookie_file)) {
            $fp = fopen($cookie_file, 'w+');
            fclose($fp);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function logs()
    {
        $completeUrl    = $this->url . '/data?action=getData';

        $data           = $this->encrypt();
        $data['table']  = 'logs';
        $data['limit']  = 10;
        $data['tojs']   = 'test';

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function addSite($domain, $path, $desc, $type_id = 0, $type = 'php', $phpversion = '74', $port = '80', $ftp = null, $ftpusername = null, $ftppassword = null, $sql = null, $userdbase = null, $passdbase = null, $setSsl = 0, $forceSsl = 0)
    {
        $completeUrl    = $this->url . '/site?action=AddSite';

        $datajson       = [
            'domain'        => $domain,
            'domainlist'    => [],
            'count'         => 0,
        ];
        $data                   = $this->encrypt();
        $data['webname']        = json_encode($datajson);
        $data['path']           = "/www/wwwroot/" . $path;
        $data['ps']             = $desc;
        $data['type_id']        = $type_id;
        $data['type']           = $type;
        $data['version']        = $phpversion;
        $data['port']           = $port;

        if (isset($ftp)) {
            $data['ftp']            = $ftp;
            $data['ftp_username']   = $ftpusername;
            $data['ftp_password']   = $ftppassword;
        }
        if (isset($sql)) {
            $data['sql']            = $sql;
            $data['datauser']       = $userdbase;
            $data['datapassword']   = $passdbase;
        }

        $data['codeing']        = 'utf8';
        $data['set_ssl']        = $setSsl;
        $data['force_ssl']      = $forceSsl;


        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function addSubDomain($subdomain, $mainDomain, $iptarget)
    {
        $completeUrl    = $this->url . '/plugin?action=a&name=dns_manager&s=act_resolve';

        $data           = $this->encrypt();
        $data['host']   = $subdomain;
        $data['value']  = $iptarget;
        $data['domain'] = $mainDomain;
        $data['ttl']    = '600';
        $data['type']   = 'A';
        $data['act']    = 'add';

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function deleteSubDomain($subdomain, $mainDomain, $iptarget)
    {
        $completeUrl    = $this->url . '/plugin?action=a&name=dns_manager&s=act_resolve';

        $data           = $this->encrypt();
        $data['host']   = $subdomain;
        $data['value']  = $iptarget;
        $data['domain'] = $mainDomain;
        $data['ttl']    = '600';
        $data['type']   = 'A';
        $data['act']    = 'delete';

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }
    public function modifySubDomain($subdomain, $mainDomain, $iptarget, $id)
    {
        $completeUrl    = $this->url . '/plugin?action=a&name=dns_manager&s=act_resolve';

        $data           = $this->encrypt();
        $data['host']   = $subdomain;
        $data['value']  = $iptarget;
        $data['domain'] = $mainDomain;
        $data['ttl']    = '600';
        $data['type']   = 'A';
        $data['act']    = 'modify';
        $data['id']     = $id;

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function subDomainList($domain, $host = null)
    {
        $completeUrl    = $this->url . '/plugin?action=a&name=dns_manager&s=get_resolve';

        $data           = $this->encrypt();
        $data['domain'] = $domain;

        $result         = $this->httpPostCookie($completeUrl, $data);
        $resultarray    = json_decode($result, true);

        if ($host) {
            foreach ($resultarray as $i => $r) {
                if ($r['host'] == $host) {
                    $resultarray = $resultarray[$i];
                    $resultarray['id'] = $i;
                    break;
                }
            }
        }
        return $resultarray;
    }

    public function unzip($sourceFile, $destinationFile, $password = null)
    {
        $completeUrl    = $this->url . '/files?action=UnZip';

        $data               = $this->encrypt();
        $data['sfile']      = $sourceFile;
        $data['dfile']      = $destinationFile;
        $data['type']       = 'zip';
        $data['coding']     = 'UTF-8';
        $data['password']   = $password;

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function forceHTTPS($sitename)
    {
        $completeUrl    = $this->url . '/site?action=HttpToHttps';

        $data               = $this->encrypt();

        $data['siteName']   = $sitename;

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function applySSL($domain, $idDomain)
    {
        $completeUrl    = $this->url . '/acme?action=apply_cert_api';

        $data               = $this->encrypt();

        $data['domains']        = '["' . $domain . '"]';
        $data['id']             = $idDomain;
        $data['auth_to']        = $idDomain;
        $data['auth_type']      = 'http';
        $data['auto_wildcard']  = '0';

        $result         = $this->httpPostCookie($completeUrl, $data);
        $result         = json_decode($result, true);

        $urlSSL     = $this->url . '/site?action=SetSSL';

        $data2      = $this->encrypt();

        $data2['type']      = '1';
        $data2['siteName']  = $domain;
        $data2['key']       = $result['private_key'];
        $data2['csr']       = $result['cert'] . ' ' . $result['root'];

        $result2        = $this->httpPostCookie($urlSSL, $data2);

        return json_decode($result2, true);
    }

    public function siteList($limit, $page, $search = null)
    {
        $completeUrl    = $this->url . '/data?action=getData';

        $data = $this->encrypt();

        $data['table']          = 'sites';
        $data['limit']          = $limit;
        $data['p']              = $page;
        $data['search']          = $search;
        $data['type']           = '-1';

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true)['data'];
    }

    public function deleteSite($webname, $id)
    {
        $completeUrl    = $this->url . '/site?action=DeleteSite';

        $data               = $this->encrypt();

        $data['ftp']        = "1";
        $data['database']   = "1";
        $data['path']       = "1";
        $data['id']         = $id;
        $data['webname']    = $webname;

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function disableSite($idDomain, $domain)
    {
        $completeUrl    = $this->url . '/site?action=SiteStop';

        $data               = $this->encrypt();

        $data['id']          = $idDomain;
        $data['name']          = $domain;

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function enableSite($idDomain, $domain)
    {
        $completeUrl    = $this->url . '/site?action=SiteStart';

        $data               = $this->encrypt();

        $data['id']          = $idDomain;
        $data['name']          = $domain;

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function importDbase($file, $dbasename)
    {
        $completeUrl    = $this->url . '/database?action=InputSql';

        $data               = $this->encrypt();

        $data['file']       = $file;
        $data['name']       = $dbasename;

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

    public function safeFileBody($datafile, $path)
    {
        $completeUrl    = $this->url . '/files?action=SaveFileBody';

        $data               = $this->encrypt();

        $data['data']       = $datafile;
        $data['path']       = $path;
        $data['encoding']   = 'utf-8';

        $result         = $this->httpPostCookie($completeUrl, $data);

        return json_decode($result, true);
    }

}
