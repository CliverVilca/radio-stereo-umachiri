<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    // app/Models/News.php
    protected $fillable = [
        'title', 'content', 'image', 'author', 'published_at', 'type', 'status', 'is_featured'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Scope para noticias publicadas
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    // Scope para noticias destacadas o recientes
    public function scopeRecent($query, $limit = 3)
    {
        return $query->published()->orderBy('published_at', 'desc')->limit($limit);
    }
}