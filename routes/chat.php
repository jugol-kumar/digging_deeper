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

Route::get('/chats', function (){
    //
});

Route::post('/chats', function (){
    $user = User::findOrFail(Auth::id());
    $message = request('message');
   event(
       (new SendMessageEvent($message, $user))->dontBroadcastToCurrentUser()
   );
//   SendMessageEvent::dispatch($message);
});
