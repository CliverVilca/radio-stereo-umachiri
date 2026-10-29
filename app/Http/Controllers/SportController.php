<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;

class SportController extends Controller
{
    public function index()
    {
        $sports = Sport::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('sports.index', compact('sports'));
    }

    public function show($id)
    {
        $sport = Sport::where('status', 'published')->findOrFail($id);
        $relatedSports = Sport::where('status', 'published')
            ->where('id', '!=', $sport->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('sports.show', compact('sport', 'relatedSports'));
    }
}
