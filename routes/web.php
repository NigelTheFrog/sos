<?php

use App\Http\Controllers\Admin\Dashboard\AvalanController;
use App\Http\Controllers\Admin\Dashboard\ItemController;
use App\Http\Controllers\Admin\Master\AreaLokasiController;
use App\Http\Controllers\Admin\Master\CompanyController;
use App\Http\Controllers\Admin\Master\GroupController;
use App\Http\Controllers\Admin\Master\KategoriProduk;
use App\Http\Controllers\Admin\Master\KategoriProdukController;
use App\Http\Controllers\Admin\Master\KeputusanController;
use App\Http\Controllers\Admin\Master\TipeUserController;
use App\Http\Controllers\Admin\Master\User;
use App\Http\Controllers\Admin\Master\UserController;
use App\Http\Controllers\Admin\Master\WarnaController;
use App\Models\Item;
use App\Http\Controllers\Admin\Penjadwalan\Impor;
use App\Http\Controllers\Admin\Penjadwalan\ImportAvalanController;
use App\Http\Controllers\Admin\Penjadwalan\ImportItemController;
use App\Models\Admin\Penjadwalan\ImportAvalan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function() {
    Route::prefix('dashboard')->group(function() {          
        Route::resource('avalan', AvalanController::class);
        Route::get("item",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'index']);
        Route::get("stop-cso-item",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'stopCsoItem']);
        Route::get("end-cso-item",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'endCSOItem']);
        Route::get('avalan',[App\Http\Controllers\Admin\Dashboard\AvalanController::class,'index']);
        Route::get("main-table-avalan",[App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'showMainTable']);
        Route::get("main-table-item",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'showMainTable']);
        Route::get("banner-avalan",[App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'showBanner']);
        Route::get('banner-avalan/{request}', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'showBannerTable'])->name('request');
        Route::get("banner-item",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'showBanner']);
        Route::get('print-item/{request}', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'print'])->name('request');
        Route::get('print-avalan/{request}', [App\Http\Controllers\Admin\Dashboard\AvalanController::class, 'print'])->name('request');
        Route::get('banner-item/{request}', [App\Http\Controllers\Admin\Dashboard\ItemController::class, 'showBannerTable'])->name('request');
    });
    Route::prefix('master')->group(function() {
        Route::resource('user', User::class);
        Route::resource('tipe-user', TipeUserController::class);      
        Route::resource('company',CompanyController::class);
        Route::resource('area-lokasi',AreaLokasiController::class);
        Route::resource('keputusan',KeputusanController::class);
        Route::resource('warna',WarnaController::class);
        Route::resource('group',GroupController::class);
        Route::resource('kategori-produk',KategoriProdukController::class);
    });
    Route::prefix('penjadwalan')->group(function() { 
        Route::resource('import-stok', ImportItemController::class) ;
        Route::post('import-stok/pull-import',[App\Http\Controllers\Admin\Penjadwalan\ImportItemController::class, 'showTable']);
        Route::resource('import-avalan', ImportAvalanController::class) ;
        Route::post('import-avalan/pull-import',[App\Http\Controllers\Admin\Penjadwalan\ImportAvalanController::class, 'showTable']);        
        Route::get('pengaturan',[App\Http\Controllers\Admin\Penjadwalan\Pengaturan::class,'index']);
        // Route::post('pengaturan/',["type"=>])
    });
});
       

Auth::routes();
Route::get("/",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'index'])->middleware(['auth','isAdmin']);
Route::get("home",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'index'])->middleware(['auth','isAdmin']);


