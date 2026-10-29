<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Sport;
use App\Models\Program;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Podcast;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'noticias'  => News::count(),
            'sports'    => Sport::count(),
            'programs'  => Program::count(),
            'events'    => Event::where('start_time', '>=', now())->count(),
            'galleries' => Gallery::count(),
            'podcasts'  => Podcast::count(),
        ];

        // Recent news
        $recentNoticias = News::latest()->take(5)->get();

        // Upcoming events
        $upcomingEvents = Event::where('start_time', '>=', now())
            ->orderBy('start_time')
            ->take(4)
            ->get();

        // Recent messages count
        $messagesCount = 0;
        try {
            $messagesCount = DB::table('contact_messages')->count();
        } catch (\Exception $e) {}

        return view('admin.dashboard', compact('stats', 'recentNoticias', 'upcomingEvents', 'messagesCount'));
    }
}
