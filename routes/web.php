<?php

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
        Route::get("item",[App\Http\Controllers\Admin\Dashboard\ItemController::class, 'index']);
        Route::get('avalan',[App\Http\Controllers\Admin\Dashboard\AvalanController::class,'index']);
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
        Route::get("impor-stok",[App\Http\Controllers\Admin\Penjadwalan\Impor::class, 'imporStok']);
        Route::get('impor-avalan',[App\Http\Controllers\Admin\Penjadwalan\Impor::class,'imporAvalan']);
        Route::get('pengaturan',[App\Http\Controllers\Admin\Penjadwalan\Pengaturan::class,'index']);
        // Route::post('pengaturan/',["type"=>])
    });
});

Route::get('/', function () {
    dd(DB::table('viewdashboard')->where('itemname','LIKE', '%%')->orWhere('analisator','LIKE','%%')->get());
});        

Auth::routes();

Route::get('/home'  , [App\Http\Controllers\HomeController::class, 'index'])->name('home');
