<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'title',
        'description',
        'audio_path',
    ];

    // published_at column does not exist in the migration, removing cast.

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Scope para podcasts publicados
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    // Scope para podcasts recientes
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()->orderBy('published_at', 'desc')->limit($limit);
    }
}
