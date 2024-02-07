<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AccountController;
use App\Http\Controllers\api\AddController;
use App\Http\Controllers\api\AnalisaatorController;
use App\Http\Controllers\api\DetailController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\ProcessController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[AccountController::class,'login']);
Route::post('mulai-cso-item',[AccountController::class,'mulaiCSOItem']);
Route::post('mulai-cso-avalan',[AccountController::class,'mulaiCSOAvalan']);

Route::get('item-list',[AddController::class,'item']);
Route::get('avalan-list',[AddController::class,'avalan']);
Route::get('location-list',[AddController::class,'lokasi']);
Route::get('color-list',[AddController::class,'warna']);

Route::post('add-item',[ProcessController::class,'addItem']);
Route::post('add-temuan-item',[ProcessController::class,'addTemuanItem']);
Route::post('add-temuan-avalan',[ProcessController::class,'addTemuanAvalan']);

Route::post('tambah-perhitungan',[ProcessController::class,'addHitung']);
Route::post('tambah-perhitungan-temuan',[ProcessController::class,'addHitungTemuan']);

Route::post('simpan-perhitungan',[ProcessController::class,'simpanHitung']);

Route::post('update-perhitungan',[DetailController::class,'updatePerhitungan']);
Route::post('update-item',[DetailController::class,'updateItem']);
Route::post('update-temuan',[DetailController::class,'updateTemuan']);

Route::post('daftar-item',[HomeController::class,'listItem']);
Route::post('daftar-avalan',[HomeController::class,'listAvalan']);
Route::post('submit-item',[HomeController::class,'submitItem']);
Route::get('check-status-cso-item',[HomeController::class,'checkCsoItemStatus']);
Route::get('check-status-cso-avalan',[HomeController::class,'checkCsoAvalanStatus']);

Route::post('daftar-item-analisator',[AnalisaatorController::class,'listItemAnalisator']);
Route::post('daftar-avalan-analisator',[AnalisaatorController::class,'listAvalanAnalisator']);
Route::post('tambah-perhitungan-item-analisator',[AnalisaatorController::class,'addHitungItem']);
Route::post('update-perhitungan-item-analisator',[AnalisaatorController::class,'simpanHitungItem']);
Route::post('update-item-analisator',[AnalisaatorController::class,'updateItemAnalisator']);