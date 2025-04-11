<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'cover',
        'description',
        'start',
        'end',
        'address',
        'available_points',
    ];
}
