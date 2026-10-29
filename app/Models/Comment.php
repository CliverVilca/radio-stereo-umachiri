<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id', 
        'name', 
        'content', 
        'approved'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    // Scope para comentarios aprobados
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    // Scope para comentarios pendientes
    public function scopePending($query)
    {
        return $query->where('approved', false);
    }
}
