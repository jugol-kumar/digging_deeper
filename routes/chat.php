<?php


use App\Http\Controllers\Chat\ChatController;
use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
| Chat Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/







Route::get('/', [ChatController::class, 'index'])->name('index');
