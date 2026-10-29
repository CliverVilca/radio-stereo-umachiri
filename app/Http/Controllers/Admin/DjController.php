<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DjController extends Controller
{
    public function index()
    {
        $djs = Dj::all();
        return view('admin.djs.index', compact('djs'));
    }

    public function create()
    {
        return view('admin.djs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $request->file('photo')->store('djs', 'public');

        Dj::create([
            'name' => $request->name,
            'bio' => $request->bio,
            'photo_path' => $path,
        ]);

        return redirect()->route('admin.djs.index')->with('success', 'DJ añadido exitosamente.');
    }

    public function edit(Dj $dj)
    {
        return view('admin.djs.edit', compact('dj'));
    }

    public function update(Request $request, Dj $dj)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'bio']);

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($dj->photo_path);
            $data['photo_path'] = $request->file('photo')->store('djs', 'public');
        }

        $dj->update($data);

        return redirect()->route('admin.djs.index')->with('success', 'DJ actualizado exitosamente.');
    }

    public function destroy(Dj $dj)
    {
        Storage::disk('public')->delete($dj->photo_path);
        $dj->delete();
        return redirect()->route('admin.djs.index')->with('success', 'DJ eliminado exitosamente.');
    }
}
