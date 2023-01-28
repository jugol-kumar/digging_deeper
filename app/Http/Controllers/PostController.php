<?php

namespace App\Http\Controllers;

use App\Events\PostSaved;
use App\Models\Post;
use App\Http\Requests\UpdatePostRequest;
use App\Models\User;
use App\Notifications\AdminPostNotification;
use App\Notifications\UserPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = \auth()->user()->unreadNotifications ?? [];
        $posts = Post::latest()->take(5)->get();
        return  view('user.index', compact('notifications', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => "required|min:3|max:60"
        ]);

//        $validate = Validator::make($request->all(),[
//           'title' => "required|min:3|max:8"
//        ])->validateWithBag('post');


        $post = Post::create([
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'description' => $request->description,
            'status' => filled($request->status)
        ]);

//
//
        event(new PostSaved($post));




//
//        $user = User::where('role_id', 1)->first();
//        Notification::send($user, new UserPostNotification($post));
        return back()->with('message', "Post Create Successfully Done!!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }


    public function infinityLoad(Request $request){
        $posts = Post::paginate(15);
        if ($request->ajax()){
            $view = view('infinity_loop.load_data', compact('posts'))->render();
            return response()->json(['view' => $view]);
        }
        return view("infinity_loop.posts", compact('posts'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function loadMore(Request $request){
        if ($request->ajax()){
            if($request->id > 0)
            {
                $data = Post::where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data =Post::orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            return $data;

        }
    }


}
