<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\TestConnectionController;
use App\Http\Controllers\TunnelActionController;
use App\Http\Controllers\TunnelController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('server', ServerController::class);

    Route::resource('tunnel', TunnelController::class);

    Route::controller(TunnelActionController::class)->name('tunnel-action.')->group(function (){
        Route::post('/disable-tunnel-remote/{tunnel}', 'disableTunnelRemote')
            ->name('disable-tunnel-remote');
        Route::post('/enable-tunnel-remote/{tunnel}', 'enableTunnelRemote')
            ->name('enable-tunnel-remote');
    });

    Route::post('/test-connection', [TestConnectionController::class, 'testConn'])->name('test-con');
    Route::post('/cek-online', [TestConnectionController::class, 'checkOnline'])->name('check-online');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
require __DIR__.'/auth.php';
