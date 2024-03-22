<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ServerController extends Controller
{

    public function index(): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $servers = Server::query()
            ->latest()->get();
        if (request()->ajax()) {
            return DataTables::of($servers)
                ->addIndexColumn()
                ->editColumn('name', function ($data) {
                    return '<span class="badge badge-soft-pink rounded-pill font-size-12">'.$data->name.
                        '</span>';
                })
                ->editColumn('host', function ($data) {
                    return '<span class="badge badge-soft-success rounded-pill font-size-12">'.$data->host.
                        '</span>';
                })
                ->editColumn('port', function ($data) {
                    return '<span class="badge badge-soft-primary rounded-pill font-size-12 rounded-pill">'.$data->port.
                        '</span>';
                })
                ->editColumn('status', function ($data) {
                    return '<span class="badge badge-soft-primary rounded-pill font-size-12 rounded-pill">'.$data->status.
                        '</span>';
                })
                ->editColumn('domain', function ($data) {
                    return '<span class="badge badge-soft-secondary rounded-pill font-size-12 rounded-pill">'.$data->domain.
                        '</span>';
                })
                ->addColumn('action', function ($data) {
                    return view('server.partial.action')->with('data', $data);
                })
                ->rawColumns(['name', 'host', 'port','domain'])
                ->make(true);
        }

        return view('server.index', compact('servers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'host' => 'required',
            'domain' => 'required',
            'username' => 'required',
            'remote_address' => 'required',
            'password' => 'required',
            'port' => 'required',
        ], [
            'name.required' => 'Nama/Identitas server harus di isi.',
            'host' => 'Host/Ip router harus di isi.',
            'domain' => 'DNS/Domain server tidak boleh kosong.',
            'remote_address' => 'Remote address tidak boleh kosong.',
            'username' => 'Username tidak boleh kosong.',
            'password' => 'Password router harus di isi.',
            'port' => 'Port harus di isi.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error',
                'title' => 'Oops Error',
                'text' => 'Gagal menambah router.',
            ]);
        } else {
          Server::create([
                'name' => $name = $request->name,
                'slug' => str($name.'-'.Str::random(4))->slug(),
                'host' => $request->host,
                'domain' => $request->domain,
                'remote_address' => $request->remote_address,
                'username' => $request->username,
                'password' => $request->password,
                'port' => $request->port,
            ]);

            return response()->json([
                'status' => 'success',
                'text' => 'Mikrotik server baru di tambahkan.',
                'title' => 'Berhasil',
            ]);
        }

    }
    public function edit(Server $server)
    {
        $where = ['slug' => $server->slug];
        $data = ServerResource::make(Server::where($where)->first());

        if (! $data) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'text' => 'Data server tidak di temukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Success.',
            'message' => 'Berhasil mendapatkan data router.',
            'data' => $data,
        ]);
    }

    public function update(Request $request, Server $server)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
            'port' => 'required',
        ], [
            'name.required' => 'Nama/Identitas server harus di isi.',
            'host' => 'Host/Ip router harus di isi.',
            'username' => 'Username tidak boleh kosong.',
            'password' => 'Password router harus di isi.',
            'port' => 'Port harus di isi.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'error',
                'title' => 'Oops Error',
                'text' => 'Gagal update data server.',
            ]);
        } else {
            $server->update([
                'name' => $name = $request->name,
                'slug' => str($name.'-'.Str::random(4))->slug(),
                'domain' => $request->domain,
                'host' => $request->host,
                'username' => $request->username,
                'password' => $request->password,
                'port' => $request->port,
            ]);

            return response()->json([
                'status' => 'success',
                'text' => 'Server berhasil di update.',
                'title' => 'Berhasil',
            ]);
        }
    }

    public function destroy(Server $server)
    {
        $server->delete();
    }

}
