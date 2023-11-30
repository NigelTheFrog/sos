<?php

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
        Route::get('user',[App\Http\Controllers\Admin\Master\User::class,'index']);
        Route::get('tipe-user',[App\Http\Controllers\Admin\Master\TipeUser::class,'index']);
        Route::get('company',[App\Http\Controllers\Admin\Master\Company::class,'index']);
        Route::get('area-lokasi',[App\Http\Controllers\Admin\Master\AreaLokasi::class,'index']);
        Route::get('warna',[App\Http\Controllers\Admin\Master\Warna::class,'index']);
        Route::get('group',[App\Http\Controllers\Admin\Master\Group::class,'index']);
        Route::get('keputusan',[App\Http\Controllers\Admin\Master\Keputusan::class,'index']);
        Route::get('kategori-produk',[App\Http\Controllers\Admin\Master\KategoriProduk::class,'index']);
    });
    Route::prefix('penjadwalan')->group(function() {  
        Route::get("impor-stok",[App\Http\Controllers\Admin\Penjadwalan\Impor::class, 'imporStok']);
        Route::get('impor-avalan',[App\Http\Controllers\Admin\Penjadwalan\Impor::class,'imporAvalan']);
        Route::get('pengaturan',[App\Http\Controllers\Admin\Penjadwalan\Pengaturan::class,'index']);
    });
});

Route::get('/', function () {
    dd(DB::table('viewdashboard')->where('itemname','LIKE', '%%')->orWhere('analisator','LIKE','%%')->get());
});        

Auth::routes();

Route::get('/home'  , [App\Http\Controllers\HomeController::class, 'index'])->name('home');
