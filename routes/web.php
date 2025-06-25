<?php

use App\Http\Controllers\BusinessSettingController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\RedisController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

//    Cache::put('new feature', "this is new feature");
    Cache::put('new feature1', "this is new feature2");
    Cache::put('new feature2', "this is new feature3");
    Cache::put('new feature3', "this is new feature4");

    Cache::pull('new feature');

    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(\App\Http\Middleware\IsAdminMiddleware::class);


Route::get('/user/profile', [\App\Http\Controllers\PostController::class, 'index'])->name('user.profile')->middleware("auth");


Route::post('/save-post',[\App\Http\Controllers\HomeController::class,'savePost'])->name('storepost');

//Route::post('/save-user-post', [])->name('user.post');

Route::resource('post', \App\Http\Controllers\PostController::class);

Route::get('/firebase-number-verification', [FirebaseController::class, "numberVerifyForm"])->name('firebase.numberverify');


Route::post('/loadmore/data', [\App\Http\Controllers\PostController::class, 'loadMore'])->name('loadmore.load_data');


Route::get("/infinity-scrolling", [\App\Http\Controllers\PostController::class, 'infinityLoad'])->name('infinityloop');


Route::get('/get-all-user', [\App\Http\Controllers\RepositoryUserController::class, 'index'])->name('user.index');
Route::get('/get-all-user/{id}', [\App\Http\Controllers\RepositoryUserController::class, 'showUser'])->name('user.index');
Route::get('/get-all-user/{id}/delete', [\App\Http\Controllers\RepositoryUserController::class, 'delete'])->name('user.index');


Route::get('/array', function (){


    $cars=array
    (
        array("Volvo",100,96),
        array("BMW",60,59),
        array("Toyota",110,100)
    );
    $cars=array("Volvo","BMW","Toyota","Honda","Mercedes","Opel");

//    return array_change_key_case($cars, CASE_UPPER);

//    return array_chunk($cars, 4);

    $a = array(
        array(
            'id' => 5698,
            'first_name' => 'Peter',
            'last_name' => 'Griffin',
        ),
        array(
            'id' => 4767,
            'first_name' => 'Ben',
            'last_name' => 'Smith',
            array(
                'my_name' => 'jugol kumar',
                'my_age' => 22,
            ),
            array(
                'my_name' => 'jugol kumar',
                'my_age' => 22,
            )
        ),
        array(
            'id' => 3809,
            'first_name' => 'Joe',
            'last_name' => 'Doe',
        )
    );

//    return array_column($a, 'first_name', 'id');

    $fname=array('first' => "Peter", 'second'=>"Ben",'thard'=>"Joe");
    $age=array('first'=>"35",'second'=>"37",'thard'=>"43");

//    return array_combine($age, $fname);

    $a=array("A","Cat","Dog","A","Dog");
//    print_r(array_count_values($a));

    $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
    $a2=array("e"=>"red","f"=>"green","g"=>"blue","d"=>"black");
//    return array_diff($a2,$a1);




});

Route::get("business-settings",[BusinessSettingController::class, 'settingView'])->name('business.setting');
Route::post('business/update', [BusinessSettingController::class, 'update'])->name('business.update');




Route::get('/send-sms', function(){
    return view('sms_tamplate');
});

Route::get('send-mail', function (){
    $user = \App\Models\User::first();
    dispatch(new \App\Jobs\RedisMail($user));
    return "send mail";
});


Route::get('send-notification', function (){
    $user = \App\Models\User::first();
    $user->notify(new \App\Notifications\RedisNotefication());
    return "send notification";
});

Route::get('send-post-notification', function (){
    $user = \App\Models\User::all()[2];
    $user->notify(new \App\Notifications\PostNotifiation());
    return "send notification";
});


Route::get('user-notification', function (){
    $user = \App\Models\User::first();


    foreach ($user->notifications as $notification) {
        dump( $notification->data );
    }
});


Route::get('/vue-chat', function (){
    return view('VuejsApp');
});


Route::get('/brotcasting', function (){
    return view('VuejsApp');
})->name('brotcasting');





// tasks

Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'tasks'])->name('tasks');
Route::get('/api/tasks', [\App\Http\Controllers\TaskController::class, 'getTasks']);
Route::view('/b-show', 'task.b_show');

Route::post('/tasks-create', [\App\Http\Controllers\TaskController::class, 'create'])->name('task.save');


Route::get('/bbbb', function (){
    \App\Events\TaskEvent::dispatch();
    event(new \App\Events\TaskEvent());

    return "ok";
});


Route::get('/carbon-date', function (){
    return \App\Http\Controllers\TaskController::index();
    $date = \Carbon\Carbon::parse("2023-01-8");
    return $date->isToday() ? "today" : "not true";
});



Route::controller(RedisController::class)->group(function(){
    Route::get('/redis/show/{id}', 'showPost');
    Route::get('/redis/index', 'index');
    Route::get('/redis/get-all', 'getAll');
});


Route::get('/export-word-file', [\App\Http\Controllers\ExportWordFile::class, 'generateDocx']);


// check model date time formatter

Route::get('/users/all', function (){
//    return \App\Models\User::find(11);
    return \App\Models\User::orderBy('id', 'desc')->get();
});

Route::get('/user/w', function (){
    $user = new \App\Models\User();
   \App\Models\User::withoutTimestamps(fn() => $user->create([
       'user_id' => Str::uuid(),
       'name'       => 'Admisn',
       'email'      => Str::random()."adsmin@mail.com",
       'password'   => Hash::make('12345678'),
       'role_id'    => Role::where('slug', 'admin')->first()->id,
       'created_at' => now(),
       'updated_at' => now()
   ]));
});
