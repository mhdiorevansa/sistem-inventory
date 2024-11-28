<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PembelianBarangController;
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
route::redirect('/', '/dashboard');
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/filter-chart', [DashboardController::class, 'filterChart']);
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
    Route::put('/update-do/{id}', [DoController::class, 'updateDo']);
    Route::delete('/delete-do/{id}', [DoController::class, 'deleteDo']);
    Route::get('cetak-do/{id}', [DoController::class, 'cetakDo']);
});

Route::group(['prefix' => 'invoice'], function () {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::get('cetak-invoice/{id}', [InvoiceController::class, 'cetakInvoice']);
    Route::get('/get-invoice', [InvoiceController::class, 'getInvoice']);
});

Route::group(['prefix' => 'pembelian-barang'], function () {
    Route::get('/', [PembelianBarangController::class, 'index']);
    Route::get('/get-data-pembelian', [PembelianBarangController::class, 'getPembelian']);
    Route::post('/create-data-pembelian', [PembelianBarangController::class, 'createPembelian']);
    Route::get('/edit-data-pembelian/{id}', [PembelianBarangController::class, 'editPembelian']);
    Route::put('/update-data-pembelian/{id}', [PembelianBarangController::class, 'updatePembelian']);
    Route::delete('/delete-data-pembelian/{id}', [PembelianBarangController::class, 'deletePembelian']);
    Route::get('export-pdf', [PembelianBarangController::class, 'exportPDF']);
});
