<?php


namespace App\Services\Impl;

use App\Services\RouterOsServiceInterface;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;

class RouterOsServiceImpl implements RouterOsServiceInterface
{

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     * @throws \Exception
     */
    function getMikrotik($server): Client
    {
        if (!$server) {
            throw new \Exception('Mikrotik not found.');
        }
        $config = (new Config())
            ->set('host', $server->host)
            ->set('port', (int)$server->port)
            ->set('pass', $server->password)
            ->set('user', $server->username);

        return new Client($config);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function addTunnel($server, $name, $pass, $localAddress, $remoteAddress, $mainProfile)
    {
        $client = $this->getMikrotik($server);
        $query = new Query('/ppp/secret/add');
        $query->equal('name', $name );
        $query->equal('password', $pass);
        $query->equal('local-address', $localAddress);
//        if (!empty($localAddress)) {
//            $query->equal('local-address', $localAddress);
//        }
        $query->equal('remote-address', $remoteAddress);

//        if (!empty($remoteAddress)) {
//            $query->equal('remote-address', $remoteAddress);
//        }
        $query->equal('comment', strtoupper($name));
        $query->equal('profile', $mainProfile);
        $query->equal('service', 'any');

        return $client->query($query)->read();
    }


    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function addFirewallNatApi($server, $name, $remoteAddress, $portApi): array
    {
        $client = $this->getMikrotik($server);
        $api = (new Query('/ip/firewall/nat/add'))
            ->equal('chain', 'dstnat')
            ->equal('action', 'dst-nat')
            ->equal('to-addresses', $remoteAddress)
            ->equal('to-ports', '8728')
            ->equal('protocol', 'tcp')
            ->equal('dst-port', $portApi)
            ->equal('comment', strtoupper($name . '-NAT-API'))
            ->equal('disabled', 'no');

        return $client->qr($api);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function addFirewallNatWinBox($server, $name, $remoteAddress, $portWinBox): array
    {
        $client = $this->getMikrotik($server);

        $winbox = (new Query('/ip/firewall/nat/add'))
            ->equal('chain', 'dstnat')
            ->equal('action', 'dst-nat')
            ->equal('to-addresses', $remoteAddress)
            ->equal('to-ports', '8291')
            ->equal('protocol', 'tcp')
            ->equal('dst-port', $portWinBox)
            ->equal('comment', strtoupper($name . '-NAT-WINBOX'))
            ->equal('disabled', 'no');

        return $client->qr($winbox);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function addFirewallNatWeb($server, $name, $remoteAddress, $portWeb): array
    {
        $client = $this->getMikrotik($server);
        $web = (new Query('/ip/firewall/nat/add'))
            ->equal('chain', 'dstnat')
            ->equal('action', 'dst-nat')
            ->equal('to-addresses', $remoteAddress)
            ->equal('to-ports', '80')
            ->equal('protocol', 'tcp')
            ->equal('dst-port', $portWeb)
            ->equal('comment', strtoupper($name . '-NAT-WEB'))
            ->equal('disabled', 'no');

        return $client->qr($web);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function deletePortApi($server, $pap)
    {
        $client = $this->getMikrotik($server);
        $getPortApi = (new Query('/ip/firewall/nat/print'))
            ->where('dst-port', $pap);
        $portApi = $client->query($getPortApi)->read();
        if (!empty($portApi[0]['.id'])) {
            $portApiId = $portApi[0]['.id'];
            $query =
                (new Query('/ip/firewall/nat/remove'))
                    ->equal('.id', $portApiId);
            $client->query($query)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function deletePortWinBox($server, $win)
    {
        $client = $this->getMikrotik($server);
        $getPortWinbox = (new Query('/ip/firewall/nat/print'))
            ->where('dst-port', $win);
        $portWinbox = $client->query($getPortWinbox)->read();
        if (!empty($portWinbox[0]['.id'])) {
            $portWinboxId = $portWinbox[0]['.id'];
            $query =
                (new Query('/ip/firewall/nat/remove'))
                    ->equal('.id', $portWinboxId);
            $client->query($query)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function deletePortWeb($server, $web)
    {
        $client = $this->getMikrotik($server);

        $getPortWeb = (new Query('/ip/firewall/nat/print'))
            ->where('dst-port', $web);
        $portWeb = $client->query($getPortWeb)->read();
        if (!empty($portWeb[0]['.id'])) {
            $portWebId = $portWeb[0]['.id'];
            $query =
                (new Query('/ip/firewall/nat/remove'))
                    ->equal('.id', $portWebId);
            $client->query($query)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function deleteTunnelSecret($server, $username)
    {
        $client = $this->getMikrotik($server);

        $getPPPSecret = (new Query('/ppp/secret/print'))
            ->where('name', $username);
        $tunnelSecret = $client->query($getPPPSecret)->read();
        if (!empty($tunnelSecret[0]['.id'])) {
            $tunnelId = $tunnelSecret[0]['.id'];

            $query =
                (new Query('/ppp/secret/remove'))
                    ->where('name', $username)
                    ->equal('.id', $tunnelId);

            $client->query($query)->read();
        }

    }


    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function deleteTunnelActive($server, $username)
    {
        $client = $this->getMikrotik($server);

        $getPPPSecret = (new Query('/ppp/active/print'))
            ->where('name', $username);

        $tunnelSecret = $client->query($getPPPSecret)->read();

        if (!empty($tunnelSecret[0]['.id'])) {
            $tunnelId = $tunnelSecret[0]['.id'];

            $query =
                (new Query('/ppp/active/remove'))
                    ->equal('.id', $tunnelId);

            $client->query($query)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function updateSecret($username, $password, $server)
    {
        $client = $this->getMikrotik($server);
        $getSecret = new Query('/ppp/secret/print');
        $getSecret->where('name', $username);
        $secrets = $client->query($getSecret)->read();


        foreach ($secrets as $secret) {

            $query = (new Query('/ppp/secret/set'))
                ->equal('.id', $secret['.id'])
                ->equal('password', $password);

            $client->query($query)->read();
        }

    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function updatePortApi($rApi, $pap, $server)
    {
        $client = $this->getMikrotik($server);

        $getNatApi = (new Query('/ip/firewall/nat/print'))
            ->where('dst-port', $pap);

        $natApi = $client->query($getNatApi)->read();

        if (!empty($natApi[0]['.id'])) {
            $natApiId = $natApi[0]['.id'];

            $query =
                (new Query('/ip/firewall/nat/set'))
                    ->equal('.id', $natApiId)
                    ->equal('to-ports', $rApi);

            $client->query($query)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function updatePortWeb($pWeb, $web, $server)
    {
        $client = $this->getMikrotik($server);
        $getNatWeb = (new Query('/ip/firewall/nat/print'))
            ->where('dst-port', $web);

        $natWeb = $client->query($getNatWeb)->read();

        if (!empty($natWeb[0]['.id'])) {
            $natWebId = $natWeb[0]['.id'];

            $query =
                (new Query('/ip/firewall/nat/set'))
                    ->equal('.id', $natWebId)
                    ->equal('to-ports', $pWeb);

            $client->query($query)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function updatePortWinbox($pWin, $win, $server)
    {
        $client = $this->getMikrotik($server);

        $getNatWinBox = (new Query('/ip/firewall/nat/print'))
            ->where('dst-port', $win);

        $natWinBox = $client->query($getNatWinBox)->read();

        if (!empty($natWinBox[0]['.id'])) {
            $natWinBoxId = $natWinBox[0]['.id'];

            $query =
                (new Query('/ip/firewall/nat/set'))
                    ->equal('.id', $natWinBoxId)
                    ->equal('to-ports', $pWin);

            $client->query($query)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function enableTunnelSecret($server, $username): void
    {
        $client = $this->getMikrotik($server);
        $toNoDisable = 'no';
        $diableTunnel = new Query('/ppp/secret/print');
        $diableTunnel->where('name', $username);
        $dissabletnls = $client->query($diableTunnel)->read();

        foreach ($dissabletnls as $dsb) {
            $q = (new Query('/ppp/secret/set'))
                ->equal('.id', $dsb['.id'])
                ->equal('disabled', $toNoDisable);
            $client->query($q)->read();
        }
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    function disableTunnelSecret($server, $username): void
    {
        $client = $this->getMikrotik($server);
        $toDisable = 'yes';
        $diableTunnel = new Query('/ppp/secret/print');
        $diableTunnel->where('name', $username);
        $dissabletnls = $client->query($diableTunnel)->read();

        foreach ($dissabletnls as $dsb) {
            $q = (new Query('/ppp/secret/set'))
                ->equal('.id', $dsb['.id'])
                ->equal('disabled', $toDisable);
            $client->query($q)->read();
        }
    }


    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function testConnection($server)
    {
        $config = (new Config())
            ->set('host', $server['host'])
            ->set('port', (int)$server['port'])
            ->set('pass', $server['password'])
            ->set('user', $server['username']);
        $client = new Client($config);

        $query = (new Query('/system/resource/print'));

        return $client->query($query)->read();
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function checkOnline($server)
    {
        $client = $this->getMikrotik($server);
        $query = (new Query('/system/resource/print'));

        return $client->query($query)->read();
    }



    function checkActiveTunnel($server,$username)
    {

    }
}
