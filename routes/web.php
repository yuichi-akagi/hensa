<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TestController;
/*

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test',[TestController::class,'index'])->name('test');
*/

use App\Http\Controllers\TopController;
use App\Http\Controllers\HsController;
Route::get('/{prefRoma}/hs_{hs_id}',[HsController::class,'index'])->name('hs');
Route::get('/',[TopController::class,'index'])->name('top');

use App\Http\Controllers\Manages\TopController as ManageTopController;
use App\Http\Controllers\Manages\HsController as ManageHsController;

if ( env('APP_DEBUG') ) {
Route::get('/manage/',[ManageTopController::class,'index'])->name('manage.top');
Route::get('/manage/{year}/hs',[ManageHsController::class,'index'])->name('manage.hs.top');
Route::get('/manage/{year}/hs={hs_id}/stat',[ManageHsController::class,'stat_index'])->name('manage.hs.stat_index');
}
