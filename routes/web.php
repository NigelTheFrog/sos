<?php

use App\Http\Controllers\Admin\Dashboard\AvalanController;
use App\Http\Controllers\Admin\Dashboard\ItemController;
use App\Http\Controllers\Admin\Konfirmas\KonfrimasiWarehouseController;
use App\Http\Controllers\Admin\Master\AreaLokasiController;
use App\Http\Controllers\Admin\Master\CompanyController;
use App\Http\Controllers\Admin\Master\GroupController;
use App\Http\Controllers\Admin\Master\KategoriProdukController;
use App\Http\Controllers\Admin\Master\KeputusanController;
use App\Http\Controllers\Admin\Master\TipeUserController;
use App\Http\Controllers\Admin\Master\UserController;
use App\Http\Controllers\Admin\Master\WarnaController;
use App\Http\Controllers\Admin\Report\ReportCekStokController;
use App\Http\Controllers\Admin\Penjadwalan\ImportAvalanController;
use App\Http\Controllers\Admin\Penjadwalan\ImportItemController;
use App\Http\Controllers\Admin\Penjadwalan\PengaturanController;
use App\Http\Controllers\Admin\Report\ReportCekStokAvalanController;
use App\Http\Controllers\Admin\Resume\AvalanSelisihController;
use App\Http\Controllers\Admin\Resume\BarangSelisihController;
use App\Http\Controllers\Admin\Resume\SusunanTimCsoAvalanController;
use App\Http\Controllers\Admin\Resume\SusunanTimCsoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
// Route::middleware(['auth'])->group(function () {
//     Route::get('/', function () {
//         return view('welcome');
//     });
// });
Route::middleware('checkurl')->group(function () {
    Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::resource('avalan', AvalanController::class);
            Route::resource('item', ItemController::class);
            Route::post('item/detail-cso-item', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'showDetailCso'])->name('item.detail-cso');
            Route::post('item/update-cso-item', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'updateCsoItem'])->name('item.update-cso');
            Route::post('item/cso-ulang', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'csoUlang'])->name('item.cso-ulang');
            Route::post('item/hapus-temuan-item', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'hapusTemuanItem'])->name('item.hapus-temuan-item');
            Route::post('avalan/detail-cso-avalan', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'showDetailCsoAvalan'])->name('avalan.detail-cso');
            Route::post('avalan/update-cso-avalan', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'updateCsoAvalan'])->name('avalan.update-cso');
            Route::post('avalan/hapus-temuan-avalan', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'hapusTemuanAvalan'])->name('avalan.hapus-temuan-avalan');
            Route::post('avalan/cso-ulang', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'csoUlang']);
            Route::post("main-table-avalan", [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'showMainTable']);
            Route::post("main-table-item", [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'showMainTable']);
            Route::get("banner-avalan", [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'showBanner']);
            Route::get("check-avalan", [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'checkAvalanBlmProses']);
            Route::get('banner-avalan/{request}', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'showBannerTable'])->name('request');
            Route::get("banner-item", [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'showBanner']);
            Route::get("check-item", [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'checkItemBlmProses']);
            Route::get('print-item/{request}', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'print'])->name('request');
            Route::get('print-avalan/{request}', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'print'])->name('request');
            Route::get('banner-item/{request}', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'showBannerTable'])->name('request');
        });
        Route::prefix('master')->group(function () {
            Route::resource('user', UserController::class);
            Route::resource('tipe-user', TipeUserController::class);
            Route::resource('company', CompanyController::class);
            Route::resource('area-lokasi', AreaLokasiController::class);
            Route::resource('keputusan', KeputusanController::class);
            Route::resource('warna', WarnaController::class);
            Route::resource('group', GroupController::class);
            Route::resource('kategori-produk', KategoriProdukController::class);
        });
        Route::prefix('penjadwalan')->group(function () {
            Route::resource('import-stok', ImportItemController::class);
            Route::post('import-stok/pull-import', [App\Http\Controllers\Admin\Penjadwalan\ImportItemController::class, 'showTable']);
            Route::resource('import-avalan', ImportAvalanController::class);
            Route::post('import-avalan/pull-import', [App\Http\Controllers\Admin\Penjadwalan\ImportAvalanController::class, 'showTable']);
            Route::resource('pengaturan', PengaturanController::class);
        });
        Route::resource('konfirmasi-wrh', KonfrimasiWarehouseController::class);
        Route::prefix('resume')->group(function () {
            Route::resource('susunan-tim-cso', SusunanTimCsoController::class);
            Route::resource('susunan-tim-cso-avalan', SusunanTimCsoAvalanController::class);
            Route::resource('barang-selisih', BarangSelisihController::class);
            Route::resource('avalan-selisih', AvalanSelisihController::class);
        });
        Route::prefix('report')->group(function () {
            Route::resource('cek-stok', ReportCekStokController::class);
            Route::resource('cek-stok-avalan', ReportCekStokAvalanController::class);
        });
    });

    Auth::routes();
    Route::get("/", [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'index'])->middleware(['auth', 'isAdmin']);
    Route::get("home", [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'index'])->middleware(['auth', 'isAdmin']);
});
