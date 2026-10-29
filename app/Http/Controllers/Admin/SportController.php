<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;

class SportController extends Controller
{
    public function index()
    {
        $sports = Sport::latest()->paginate(10);
        return view('admin.sports.index', compact('sports'));
    }

    public function create()
    {
        return view('admin.sports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sports', 'public');
        }

        Sport::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author' => $validated['author'],
            'published_at' => $validated['published_at'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.sports.index')->with('success', 'Noticia de deportes creada correctamente.');
    }

    public function show(Sport $sport)
    {
        return view('admin.sports.show', compact('sport'));
    }

    public function edit(Sport $sport)
    {
        return view('admin.sports.edit', compact('sport'));
    }

    public function update(Request $request, Sport $sport)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($sport->image) {
                \Storage::disk('public')->delete($sport->image);
            }
            $imagePath = $request->file('image')->store('sports', 'public');
            $sport->image = $imagePath;
        }

        $sport->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author' => $validated['author'],
            'published_at' => $validated['published_at'],
        ]);

        $sport->save();

        return redirect()->route('admin.sports.index')->with('success', 'Noticia de deportes actualizada correctamente.');
    }

    public function destroy(Sport $sport)
    {
        if ($sport->image) {
            \Storage::disk('public')->delete($sport->image);
        }
        $sport->delete();
        return redirect()->route('admin.sports.index')->with('success', 'Noticia de deportes eliminada correctamente.');
    }
}
