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
        
    Route::get("dashboard/item",[App\Http\Controllers\Admin\ItemController::class, 'index']);
    Route::get('dashboard/avalan',[App\Http\Controllers\Admin\AvalanController::class,'index']);
});

Route::get('/', function () {
    dd(DB::table('viewdashboard')->where('itemname','LIKE', '%%')->orWhere('analisator','LIKE','%%')->get());
});        

Auth::routes();

Route::get('/home'  , [App\Http\Controllers\HomeController::class, 'index'])->name('home');
