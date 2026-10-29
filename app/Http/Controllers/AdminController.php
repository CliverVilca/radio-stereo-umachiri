<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Return the admin layout that loads the React SPA
        return view('layouts.admin');
    }

    public function programs()
    {
        $programs = [
            [
                'id' => 1,
                'name' => 'Despertar Umachiri',
                'host' => 'Juan Pérez',
                'time' => '06:00 - 09:00',
                'status' => 'live'
            ],
            [
                'id' => 2,
                'name' => 'Música del Recuerdo',
                'host' => 'María López',
                'time' => '09:00 - 12:00',
                'status' => 'upcoming'
            ],
            [
                'id' => 3,
                'name' => 'Noticias del Día',
                'host' => 'Carlos Rodríguez',
                'time' => '12:00 - 14:00',
                'status' => 'upcoming'
            ],
            [
                'id' => 4,
                'name' => 'Tarde Musical',
                'host' => 'Ana Martínez',
                'time' => '14:00 - 17:00',
                'status' => 'upcoming'
            ]
        ];

        return view('admin.programs', compact('programs'));
    }

    public function messages()
    {
        $messages = DB::table('contact_messages')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.messages', compact('messages'));
    }

    public function analytics()
    {
        $analytics = [
            'page_views' => rand(1000, 5000),
            'unique_visitors' => rand(500, 2000),
            'avg_session_duration' => '5:30',
            'bounce_rate' => '35%',
            'top_pages' => [
                'Inicio' => rand(200, 800),
                'Programación' => rand(100, 400),
                'Galería' => rand(50, 200)
            ]
        ];

        return view('admin.analytics', compact('analytics'));
    }
} 