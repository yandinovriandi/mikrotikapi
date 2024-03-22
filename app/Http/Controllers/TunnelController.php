<?php

namespace App\Http\Controllers;

use App\Http\Resources\TunnelResource;
use App\Models\Enums\TunnelStatus;
use App\Models\Server;
use App\Models\Tunnel;
use App\Services\RouterOsServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TunnelController extends Controller
{
    private RouterOsServiceInterface $routerOsService;

    public function __construct(RouterOsServiceInterface $routerOsService)
    {
        $this->routerOsService = $routerOsService;
    }

    /**
     * @throws \Exception
     */
    public function index(Request $request): View|Factory|JsonResponse|Application
    {
        if ($request->ajax()) {
          $tunnels = Tunnel::with('server')
                ->select('id','server_id','username', 'domain', 'api', 'status','slug')
                ->latest()->get();

            return DataTables::of($tunnels)
                ->addIndexColumn()
                ->editColumn('username', function ($data) {
                    return '<span class="badge badge-soft-pink rounded-pill font-size-12">'.$data->username.'</span>';
                })
                ->editColumn('domain', function ($data) {
                    return '<span class="badge badge-soft-success rounded-pill font-size-12">'.$data->domain.'</span>';
                })
                ->editColumn('server', function ($data) {
                    return '<span class="badge badge-soft-danger rounded-pill font-size-12">'.$data->server->name.'</span>';
                })

                ->editColumn('api', function ($data) {
                    return '<span class="badge badge-soft-primary rounded-pill font-size-12 rounded-pill">'.$data->api.'</span>';
                })
                ->editColumn('status', function ($data) {
                    $status = strtolower($data->status);
                    $badge = $status == TunnelStatus::ACTIVE->value ? 'badge badge-soft-success rounded-pill font-size-12' : 'badge badge-soft-danger rounded-pill font-size-12';
                    return '<div class="badge '.$badge.' rounded-fill">'.$status.'</div>';
                })
                ->addColumn('action', function ($data) {
                    return view('tunnel.partial.action')->with('data',$data);
                })

                ->rawColumns(['server','username', 'api', 'domain', 'status', 'action'])
                ->make(true);
        }
        $servers = Server::query()->select('name', 'id')->get('name', 'id');
        return view('tunnel.index', compact('servers'));
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'server_id' => 'required',
                'username' => 'required',
                'password' => 'required',
                'to_ports_api' => 'required',
                'to_ports_winbox' => 'required',
                'to_ports_web' => 'required',
            ], [
                'server_id.required' => 'Server harus dipilih.',
                'username.required' => 'Username tidak boleh kosong.',
                'password.required' => 'Password tidak boleh kosong.',
                'to_ports_api.required' => 'Port API tidak boleh kosong.',
                'to_ports_winbox.required' => 'Port Winbox tidak boleh kosong.',
                'to_ports_web.required' => 'Port Web tidak boleh kosong.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'status' => 'error',
                    'title' => 'Oops Error',
                    'text' => 'Gagal membuat tunnel remote.',
                ]);
            }

            $server = Server::find($request->input('server_id'));
            if (!$server) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Oops Error',
                    'text' => 'Server tidak ditemukan.',
                ]);
            }

            $localAddress = $server->remote_address;
            $previousIpAddress = Tunnel::pluck('remote_address')->toArray();
            $remoteAddress = generateIp($localAddress, $previousIpAddress);
            if (!$remoteAddress) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Oops Error',
                    'text' => 'Gagal membuat alamat IP unik.',
                ]);
            }
            $previousPorts = Tunnel::pluck('api')->merge(Tunnel::pluck('web'))->merge(Tunnel::pluck('winbox'))->toArray();
            $portApi = generatePort(4, $previousPorts);
            $portWinBox = generatePort(4, $previousPorts);
            $portWeb = generatePort(4, $previousPorts);


            $name = $request->username;
            $pass = $request->password;
            Tunnel::create([
                'server_id' => $server->id,
                'username' => $name,
                'slug' => Str::slug($name . '-' . Str::random(4)),
                'password' => $pass,
                'status' => TunnelStatus::ACTIVE->value,
                'local_address' => $localAddress,
                'remote_address' => $remoteAddress,
                'domain' => $server->domain,
                'api' => $portApi,
                'winbox' => $portWinBox,
                'web' => $portWeb,
                'to_ports_api' => $request->to_ports_api,
                'to_ports_winbox' => $request->to_ports_winbox,
                'to_ports_web' => $request->to_ports_web,
            ]);

            $mainProfile = 'default';

            $this->routerOsService->addTunnel($server, $name, $pass, $localAddress, $remoteAddress, $mainProfile);
            $this->routerOsService->addFirewallNatApi($server, $name, $remoteAddress, $portApi);
            $this->routerOsService->addFirewallNatWinbox($server, $name, $remoteAddress, $portWinBox);
            $this->routerOsService->addFirewallNatWeb($server, $name, $remoteAddress, $portWeb);


            return response()->json([
                'status' => 'success',
                'text' => 'Tunnel berhasil dibuat.',
                'title' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Oops! Terjadi Kesalahan',
                'text' => 'Terjadi kesalahan saat membuat tunnel: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Tunnel $tunnel)
    {
        $where = ['slug' => $tunnel->slug];
        $data = TunnelResource::make(Tunnel::where($where)->first());

        if (! $data) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'text' => 'Data tunnel tidak di temukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Success.',
            'message' => 'Berhasil mendapatkan data tunnel.',
            'data' => $data,
        ]);
    }

    public function update(Request $request, Tunnel $tunnel)
    {
        $server = Server::find($tunnel->server_id);


        $validator = Validator::make($request->all(), [
            'server_id' => 'required',
            'username' => 'required',
            'password' => 'required',
            'to_ports_api' => 'required',
            'to_ports_winbox' => 'required',
            'to_ports_web' => 'required',
        ], [
            'server_id.required' => 'Server harus dipilih.',
            'username.required' => 'Username tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
            'to_ports_api.required' => 'Port API tidak boleh kosong.',
            'to_ports_winbox.required' => 'Port Winbox tidak boleh kosong.',
            'to_ports_web.required' => 'Port Web tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error',
                'title' => 'Oops Error',
                'text' => 'Gagal memperbarui tunnel remote.',
            ]);
        }

        $password = $request->password;
        $username = $tunnel->username;
        $pWeb = $request->to_ports_web;
        $rApi = $request->to_ports_api;
        $pWin = $request->to_ports_winbox;
        $web = $tunnel->web;
        $pap = $tunnel->api;
        $win = $tunnel->winbox;



        $tunnel->update([
            'server_id' => $server->id,
            'username' => $request->username,
            'password' => $password,
            'to_ports_api' => $rApi,
            'to_ports_winbox' => $pWin,
            'to_ports_web' => $pWeb,
        ]);

        $this->routerOsService->updatePortApi($rApi, $pap, $server);
        $this->routerOsService->updatePortWinbox($pWin, $win, $server);
        $this->routerOsService->updatePortWeb($pWeb, $web, $server);
        $this->routerOsService->updateSecret($username, $password, $server);


        return response()->json([
            'status' => 'success',
            'title' => 'Berhasil',
            'text' => 'Tunnel berhasil di update.',
        ]);
    }

    public function destroy(Tunnel $tunnel)
    {
        $server = Server::find($tunnel->server_id);

        $username = $tunnel->username;
        $pap = $tunnel->api;
        $win = $tunnel->winbox;
        $web = $tunnel->web;

        $this->routerOsService->deletePortApi($server, $pap);
        $this->routerOsService->deletePortWinbox($server, $win);
        $this->routerOsService->deletePortWeb($server, $web);

        $this->routerOsService->deleteTunnelActive($server, $username);
        $this->routerOsService->deleteTunnelSecret($server, $username);
        $tunnel->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Berhasil',
            'text' => 'Tunnel berhasil dihapus.',
        ]);
    }

}
