<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author',
        'category',
        'image',
        'published_at',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];
}
