<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array)
 */
class BusinessSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

}
