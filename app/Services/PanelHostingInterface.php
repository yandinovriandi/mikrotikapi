<?php

namespace App\Services;

interface PanelHostingInterface
{
    public function logs();

    public function addSite($domain, $path, $desc, $type_id = 0, $type = 'php', $phpversion = '73', $port = '80', $ftp = null, $ftpusername = null, $ftppassword = null, $sql = null, $userdbase = null, $passdbase = null, $setSsl = 0, $forceSsl = 0);

    public function addSubDomain($subdomain, $mainDomain, $iptarget);

    public function deleteSubDomain($subdomain, $mainDomain, $iptarget);

    public function modifySubDomain($subdomain, $mainDomain, $iptarget, $id);

    public function subDomainList($domain, $host = null);

    public function unzip($sourceFile, $destinationFile, $password = null);

    public function forceHTTPS($sitename);

    public function applySSL($domain, $idDomain);

    public function siteList($limit, $page, $search = null);

    public function deleteSite($webname, $id);

    public function disableSite($idDomain, $domain);

    public function enableSite($idDomain, $domain);

    public function importDbase($file, $dbasename);

    public function safeFileBody($datafile, $path);
}
