<?php

use App\Http\Controllers\DoController;
use App\Http\Controllers\PenawaranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::group(['prefix' => 'penawaran'], function () {
    Route::get('/', [PenawaranController::class, 'index']);
    Route::get('/get-penawaran', [PenawaranController::class, 'getPenawaran']);
    Route::post('/create-penawaran', [PenawaranController::class, 'createPenawaran']);
    Route::get('/edit-penawaran/{id}', [PenawaranController::class, 'editPenawaran']);
    Route::put('/update-penawaran/{id}', [PenawaranController::class, 'updatePenawaran']);
    Route::delete('/delete-penawaran/{id}', [PenawaranController::class, 'deletePenawaran']);
    Route::get('export-pdf', [PenawaranController::class, 'exportPDF']);
    Route::post('/update-ariba', [PenawaranController::class, 'updateAriba']);
});

Route::group(['prefix' => 'delivery-order'], function () {
    Route::get('/', [DoController::class, 'index']);
    Route::get('/get-perusahaan', [DoController::class, 'getPerusahaan']);
    Route::post('/create-perusahaan', [DoController::class, 'createPerusahaan']);
    Route::get('/edit-perusahaan/{id}', [DoController::class, 'editPerusahaan']);
    Route::put('/update-perusahaan/{id}', [DoController::class, 'updatePerusahaan']);
    Route::delete('/delete-perusahaan/{id}', [DoController::class, 'deletePerusahaan']);
    Route::get('/get-do', [DoController::class, 'getDo']);
    Route::get('/list-perusahaan', [DoController::class, 'getListPerusahaan']);
    Route::get('/no-surat-jalan', [DoController::class, 'getNoSuratJalan']);
    Route::get('/no-surat-inv', [DoController::class, 'getNoInv']);
    Route::post('/create-do', [DoController::class, 'createDo']);
    Route::get('/edit-do/{id}', [DoController::class, 'editDo']);
    Route::delete('/delete-do/{id}', [DoController::class, 'deleteDo']);
});
