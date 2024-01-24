<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AccountController;
use App\Http\Controllers\api\AddController;
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
Route::post('mulai-cso',[AccountController::class,'mulaiCSO']);

Route::get('item-list',[AddController::class,'item']);
Route::get('avalan-list',[AddController::class,'avalan']);
Route::get('location-list',[AddController::class,'lokasi']);
Route::get('color-list',[AddController::class,'warna']);

Route::post('add-item',[ProcessController::class,'addItem']);
Route::post('tambah-perhitungan',[ProcessController::class,'addHitung']);
Route::post('simpan-perhitungan',[ProcessController::class,'simpanHitung']);
Route::post('add-temuan-item',[ProcessController::class,'addTemuanItem']);
Route::post('add-temuan-avalan',[ProcessController::class,'addTemuanAvalan']);

Route::post('daftar-item',[HomeController::class,'listItem']);
Route::post('submit-item',[HomeController::class,'submitItem']);






