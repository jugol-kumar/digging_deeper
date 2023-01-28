<?php

namespace App\Models;

use App\Events\PostSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

//    protected $dispatchesEvents =[
//        'created' => PostSaved::class,
//        'deleted' => PostSaved::class,
//    ];

}
