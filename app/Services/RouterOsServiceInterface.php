<?php

namespace App\Services;

interface RouterOsServiceInterface
{
    function getMikrotik($server);
    function addTunnel($server,$name, $pass, $localAddress, $remoteAddress, $mainProfile);
    function addFirewallNatApi($server,$name, $remoteAddress, $portApi);
    function addFirewallNatWinBox($server,$name, $remoteAddress, $portWinBox);
    function addFirewallNatWeb($server, $name, $remoteAddress, $portWeb);
    function deletePortApi($server, $pap);
    function deletePortWinBox($server, $win);
    function deletePortWeb($server, $web);
    function deleteTunnelSecret($server, $username);
    function deleteTunnelActive($server, $username);
    function updateSecret($username, $password, $server);
    function updatePortApi($rApi, $pap, $server);
    function updatePortWinBox($pWin, $win, $server);
    function updatePortWeb($pWeb, $web, $server);
    function enableTunnelSecret($server, $username);
    function disableTunnelSecret($server, $username);
//    function togglePppSecretStatus($server, $username, $enable);
    function checkActiveTunnel($server, $username);
    public function checkOnline($server);
    public function testConnection($server);
}
