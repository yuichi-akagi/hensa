<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\HsController;
Route::get('/univ.json',[HsController::class,'univ_json'])->name('hs.univ_json');
Route::get('/univ_grad_count.json',[HsController::class,'univ_grad_count_json'])->name('hs.univ_grad_count_json');
