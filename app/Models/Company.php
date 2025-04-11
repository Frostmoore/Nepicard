<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'coordinates',
        'website',
        'category',
        'email',
        'phone',
        'status',
        'points',
        'piva',
        'cf',
        'pec',
        'codice_univoco',
    ];
    
}