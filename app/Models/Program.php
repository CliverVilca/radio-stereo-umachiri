<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'host',
        'days_of_week',
        'start_time',
        'end_time',
        'image',
        'is_featured',
    ];

    protected $casts = [
        'days_of_week' => 'array',
    ];

    public function podcasts()
    {
        return $this->hasMany(Podcast::class);
    }
}
