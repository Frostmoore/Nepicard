<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start',
        'end',
        'points',
        'picture',
        'company',
        'short_description',
        'url',
        'type',
        'status',
        'category',
        'address',
        'coordinates'
    ];
}
