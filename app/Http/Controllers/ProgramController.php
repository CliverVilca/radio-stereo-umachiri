<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $allPrograms = Program::all();
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        // Inicializar arreglo agrupado
        $programs = [];
        foreach ($days as $day) {
            $programs[$day] = collect();
        }

        // Agrupar programas por cada día en days_of_week
        foreach ($allPrograms as $program) {
            foreach ($program->days_of_week as $day) {
                if (in_array($day, $days)) {
                    $programs[$day]->push($program);
                }
            }
        }

        // Obtener programas destacados (si decides implementar esta funcionalidad)
        $featuredPrograms = Program::where('is_featured', true)->get();

        return view('programs.index', compact('programs', 'days', 'featuredPrograms'));
    }

    public function podcasts(Program $program)
    {
        $podcasts = $program->podcasts()->latest()->get();
        return view('programs.podcasts', compact('program', 'podcasts'));
    }
}