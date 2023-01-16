<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function showPost($id){
//        $redisObj = Redis::connection();
//        $redisObj->set("foo", "bar");
//        return $redisObj->get("foo");



        if (Redis::zScore("articleViews", "article:$id")){
            Redis::pipeline(function ($pipe) use($id){
                $pipe->zIncrBy("articleViews", 1, "article$id");
                $pipe->incr("article:$id:views");
            });
        }else{
            $view = Redis::incr("article:$id:views");
            Redis::zIncrBy("articleViews", $view, "article$id");
        }
        $view = Redis::get("article:$id:views");
        return "this article $id is views in $view Times";
    }

    public function index(){
        $popularPosts = Redis::zRevRange("articleViews", 0, -1);
        foreach ($popularPosts as $value) {
            $id = str_replace("article", "", $value);
            print_r("Article views is".$id."<br>");
        }
    }

    public function getAll(){
        $data = [
            [
                'id' => 1,
                'title' => "First blog Post",
            ],
            [
                'id' => 2,
                'title' => "First blog Post",
            ],

            [
                'id' => 3,
                'title' => "First blog Post",
            ],

            [
                'id' => 4,
                'title' => "First blog Post",
            ],
        ];
//
//        Cache::put('foo', 'bar');
//
////        return Cache::get('foo');
//


//        $data = Cache::rememberForever("allData",  function ()use($data){
//            return Task::all();
//        });

        return Cache::get('allData');
//        return $data;


    }


}
