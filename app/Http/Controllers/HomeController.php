<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\News;
use App\Models\Sport;
use App\Models\Program;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Dj;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // app/Http\Controllers\HomeController.php
    public function index()
    {
        $latestNews = Cache::remember('latest_news', 3600, function () { // Cache por 1 hora
            return News::where('status', 'published')
                      ->where('published_at', '<=', now())
                      ->orderBy('published_at', 'desc')
                      ->take(3)
                      ->get();
        });

        $latestNewsForModal = Cache::remember('latest_news_modal', 3600, function () {
            return News::where('status', 'published')
                      ->where('published_at', '<=', now())
                      ->orderBy('published_at', 'desc')
                      ->take(1)
                      ->get();
        });

        $featuredSports = Cache::remember('featured_sports', 3600, function () {
            return Sport::where('status', 'published')
                       ->where('is_featured', true)
                       ->where('published_at', '<=', now())
                       ->orderBy('published_at', 'desc')
                       ->take(3)
                       ->get();
        });

        $featuredPrograms = Cache::remember('featured_programs', 3600, function () {
            return Program::where('is_featured', true)
                         ->take(3)
                         ->get();
        });

        $upcomingEvents = Cache::remember('upcoming_events', 3600, function () {
            return Event::where('is_featured', true)
                       ->where('start_time', '>', now())
                       ->orderBy('start_time', 'asc')
                       ->take(3)
                       ->get();
        });

        $featuredGalleries = Cache::remember('featured_galleries', 3600, function () {
            return Gallery::where('is_featured', true)
                         ->latest()
                         ->take(3)
                         ->get();
        });

        return view('home', compact('latestNews', 'latestNewsForModal', 'featuredSports', 'featuredPrograms', 'upcomingEvents', 'featuredGalleries'));
    }
}
