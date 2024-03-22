<?php

namespace App\Http\Controllers;

use App\Models\Enums\TunnelStatus;
use App\Models\Server;
use App\Models\Tunnel;
use App\Services\RouterOsServiceInterface;
use Illuminate\Http\Request;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;

class TunnelActionController extends Controller
{
    private RouterOsServiceInterface $routerOsService;

    public function __construct(RouterOsServiceInterface $routerOsService)
    {
        $this->routerOsService = $routerOsService;
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function disableTunnelRemote(Tunnel $tunnel)
    {
        $server = Server::find($tunnel->server_id);
        $username = $tunnel->username;
        $this->routerOsService->disableTunnelSecret($server, $username);
        $this->routerOsService->deleteTunnelActive($server, $username);
        $tunnel->update(['status' => TunnelStatus::OFFLINE->value]);
        return response()->json([
            'status' => 'success',
            'title' => 'Berhasil',
            'text' => 'Tunnel berhasil di nonaktifkan.',
        ]);
    }

        public function enableTunnelRemote(Tunnel $tunnel)
    {
        $server = Server::find($tunnel->server_id);
        $username = $tunnel->username;
        $this->routerOsService->enableTunnelSecret($server, $username);
        $tunnel->update(['status' => TunnelStatus::ACTIVE->value]);
        return response()->json([
            'status' => 'success',
            'title' => 'Berhasil',
            'text' => 'Tunnel berhasil di aktifkan.',
        ]);
    }

}
