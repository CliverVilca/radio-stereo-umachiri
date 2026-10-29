<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticias = \App\Models\News::orderBy('published_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('noticias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'type' => 'required|in:local,internacional',
            'status' => 'required|in:draft,published', // ✅ AGREGAR ESTA VALIDACIÓN
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        \App\Models\News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author' => $validated['author'],
            'published_at' => $validated['published_at'],
            'type' => $validated['type'],
            'status' => $validated['status'], // ✅ AGREGAR ESTE CAMPO
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $noticia = \App\Models\News::findOrFail($id);
        return view('admin.noticias.show', compact('noticia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $noticia = \App\Models\News::findOrFail($id);
        return view('admin.noticias.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     */
    // En el método update del NewsController
    public function update(Request $request, $id)
    {
        $news = \App\Models\News::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'type' => 'required|in:local,internacional',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejar eliminación de imagen
        if ($request->has('remove_image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
                $news->image = null;
            }
        }

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $news->image = $imagePath;
        }

        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author' => $validated['author'],
            'published_at' => $validated['published_at'],
            'type' => $validated['type'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $news = \App\Models\News::findOrFail($id);
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return redirect()->route('admin.noticias.index')->with('success', 'Noticia eliminada correctamente.');
    }
}