<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    public function numberVerifyForm(){
        return view('auth.numberverifyform');
    }
}
