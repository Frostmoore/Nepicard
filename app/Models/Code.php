<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $fillable = [
        'code',
        'user',
        'company',
        'qr',
        'points',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

}
