<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'image',
        'is_featured',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_featured' => 'boolean',
    ];
}
