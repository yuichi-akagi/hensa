<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\HsController;
Route::get('/univ.json',[HsController::class,'univ_json'])->name('hs.univ_json');
Route::get('/ss_line.json',[HsController::class,'ss_line_json'])->name('hs.ss_line_json');
Route::get('/univ2.json',[HsController::class,'univ2_json'])->name('hs.univ2_json');
Route::get('/univ_grad_count.json',[HsController::class,'univ_grad_count_json'])->name('hs.univ_grad_count_json');
