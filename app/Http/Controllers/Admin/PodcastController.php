<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function index(Program $program)
    {
        return view('admin.podcasts.index', compact('program'));
    }

    public function create(Program $program)
    {
        return view('admin.podcasts.create', compact('program'));
    }

    public function store(Request $request, Program $program)
    {
        $request->validate([
            'title' => 'required',
            'audio' => 'required|mimes:mp3,wav,ogg',
        ]);

        $path = $request->file('audio')->store('podcasts', 'public');

        $program->podcasts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'audio_path' => $path,
        ]);

        return redirect()->route('admin.programs.podcasts.index', $program)->with('success', 'Podcast añadido.');
    }

    public function edit(Program $program, Podcast $podcast)
    {
        return view('admin.podcasts.edit', compact('program', 'podcast'));
    }

    public function update(Request $request, Program $program, Podcast $podcast)
    {
        $request->validate([
            'title' => 'required',
            'audio' => 'mimes:mp3,wav,ogg',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('audio')) {
            Storage::disk('public')->delete($podcast->audio_path);
            $data['audio_path'] = $request->file('audio')->store('podcasts', 'public');
        }

        $podcast->update($data);

        return redirect()->route('admin.programs.podcasts.index', $program)->with('success', 'Podcast actualizado.');
    }

    public function destroy(Program $program, Podcast $podcast)
    {
        Storage::disk('public')->delete($podcast->audio_path);
        $podcast->delete();
        return redirect()->route('admin.programs.podcasts.index', $program)->with('success', 'Podcast eliminado.');
    }
}
