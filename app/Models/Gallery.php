<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'images',
        'is_featured',
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
    ];
}
