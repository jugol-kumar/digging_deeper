<?php

use Illuminate\Http\Request;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(\App\Http\Middleware\IsAdminMiddleware::class);


Route::get('/user/profile', [\App\Http\Controllers\PostController::class, 'index'])->name('user.profile');


Route::post('/save-post',[\App\Http\Controllers\HomeController::class,'savePost'])->name('storepost');

Route::post('/save-user-post', function (Request $request){
    return $request;
})->name('user.post');

