<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Services\Impl\RouterOsServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestConnectionController extends Controller
{
    private RouterOsServiceImpl $testConnectionService;

    public function __construct(RouterOsServiceImpl $testConnectionService)
    {
        $this->testConnectionService = $testConnectionService;
    }

    public function testConn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'host' => 'required',
            'password' => 'required',
            'username' => 'required',
            'port' => 'required',
        ], [
            'host.required' => 'Host harus diisi.',
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.',
            'port.required' => 'Port harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal terkoneksi!',
                'errors' => $validator->errors(),
            ], 400);
        }

        $server = [
            'timeout' => 1,
            'host' => $request->input('host'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'port' => (int) $request->input('port'),
        ];
        try {
            $response = $this->testConnectionService->testConnection($server);

            return response()->json([
                'status' => 'success',
                'title' => $response[0]['board-name'].' ⇌ CONNECTED',
                'text' => 'Silahkan lanjutkan proses penambahan server!',
                'boardName' => $response[0]['board-name'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal terkoneksi!',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkOnline(Request $request)
    {
        $server = Server::findOrFail($request->id);
        try {
            $response = $this->testConnectionService->checkOnline($server);

            return response()->json([
                'status' => 'success',
                'title' => $server->name.' ⇌ CONNECTED',
                'text' => 'Router ⇌'.$response[0]['board-name'].'⇌ Online',
                'boardName' => $response[0]['board-name'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Server sedang offline!',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
