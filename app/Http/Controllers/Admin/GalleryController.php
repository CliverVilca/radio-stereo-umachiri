<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Imagen añadida a la galería.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image_path);
            $data['image_path'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Imagen actualizada.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Imagen eliminada.');
    }
}
