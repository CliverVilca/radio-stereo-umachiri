<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        Event::create($request->all());

        return redirect()->route('admin.events.index')->with('success', 'Evento creado exitosamente.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $event->update($request->all());

        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado exitosamente.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
