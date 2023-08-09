<?php

use App\Http\Controllers\C_buku;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('buku',[C_buku::class,'index']);
Route::post('buku',[C_buku::class,'store']);
Route::get('buku/{id}',[C_buku::class,'edit']);
Route::put('buku/{id}',[C_buku::class,'update']);
Route::delete('buku/{id}',[C_buku::class,'destroy']);

// Route::apiResource('buku',C_buku::class);
