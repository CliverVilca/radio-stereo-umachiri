<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_time', 'asc')->paginate(10);
        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
