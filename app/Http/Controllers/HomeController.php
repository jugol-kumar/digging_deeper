<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware(IsAdminMiddleware::class);
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with('user', 'user.role:id,slug')
                ->get();
        $notifications = Auth::user()->unreadNotifications;

        return view('home', compact('posts', 'notifications'));
    }

    public function savePost(PostRequest $request){

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request['title']);
        $data['status' ] = filled($request['status']);
        Post::create($data);
        return back()->with('message', "Post Save Successfully Done");
    }
}
