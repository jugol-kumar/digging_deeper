<?php

namespace App\Http\Controllers\Chat;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(){
        return view('chat.chatting');
    }

    public function send(Request $request){
        $request->validate([
           'data.message' => 'required|min:5|string'
        ],[
            'data.message.required' => 'Please Type An Message For Your Friend...!',
            'data.message.min' => 'Please Write An Message More Then 5 Character...!'
        ]);

        event(new ChatEvent($request["data"]["message"]));
        return back();
    }

}
