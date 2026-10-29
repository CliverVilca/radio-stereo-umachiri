<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programsByDay = [];
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $programs = Program::all();

        foreach ($days as $day) {
            $programsByDay[$day] = $programs->filter(function ($program) use ($day) {
                return in_array($day, $program->days_of_week);
            });
        }

        return view('admin.programs.index', ['programs' => $programsByDay, 'days' => $days]);
    }

    public function create()
    {
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        return view('admin.programs.create', compact('days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'host' => 'required|string|max:255',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('programs', 'public');
        }

        Program::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'host' => $validated['host'],
            'days_of_week' => $validated['days_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'image' => $imagePath,
            'is_featured' => $request->has('is_featured') ? true : false,
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Programa creado correctamente.');
    }

    public function edit(Program $program)
    {
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        return view('admin.programs.edit', compact('program', 'days'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'host' => 'required|string|max:255',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($program->image) {
                \Storage::disk('public')->delete($program->image);
            }
            $imagePath = $request->file('image')->store('programs', 'public');
            $program->image = $imagePath;
        }

        $program->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'host' => $validated['host'],
            'days_of_week' => $validated['days_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_featured' => $request->has('is_featured') ? true : false,
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Programa actualizado correctamente.');
    }

    public function destroy(Program $program)
    {
        if ($program->image) {
            \Storage::disk('public')->delete($program->image);
        }
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Programa eliminado correctamente.');
    }
}
