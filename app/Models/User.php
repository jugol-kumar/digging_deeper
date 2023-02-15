<?php

namespace App\Models;

use App\Events\UserRegistrationEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

/**
 * @property mixed email
 * @method static findOrFail(int|string|null $id)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        //'user_id', 'created_at', 'updated_at'
    ];
//    protected $attributes = [
//        'email_verified_at' => "12.12.12"
//    ];


//    protected $connection = 'sqlite';
    public function newUniqueId()
    {
        return (string) Str::uuid();
    }
    public function uniqueIds()
    {
        return ['user_id'];
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => UserRegistrationEvent::class,
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function chats(){
        return $this->hasMany(Chat::class, 'form_id');
    }



}
