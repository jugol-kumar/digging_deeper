<?php


use App\Events\SendMessageEvent;
use App\Http\Controllers\Chat\ChatController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::get('/users', [ChatController::class, 'users'])->name('users')->middleware('auth');;
Route::get('/users/{id}', [ChatController::class, 'user'])->name('users')->middleware('auth');;
Route::post('/chats', [ChatController::class, 'sendMessage'])->name('send');


Route::get('/chats', function (){
    //
});

Route::fallback(function() {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
