<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dj extends Model
{
    protected $fillable = [
        'name',
        'specialty',
        'bio',
        'email',
        'phone',
        'photo_path',
        'image',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
