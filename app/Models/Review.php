<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //review model
    protected $fillable = [
        'name',
        'email',
        'phone',
        'package_name',
        'rating',
        'review',
        'photo',
        'status',
    ];
     protected $casts = [
        'rating' => 'integer',
    ];
}
