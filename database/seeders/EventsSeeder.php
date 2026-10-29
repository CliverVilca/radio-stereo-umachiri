<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'title' => 'Festival de Música Andina 2024',
                'description' => 'Gran festival de música andina con artistas locales y regionales. Ven a disfrutar de la mejor música folclórica en un ambiente familiar y festivo.',
                'start_time' => Carbon::now()->addDays(15)->setTime(18, 0),
                'end_time' => Carbon::now()->addDays(15)->setTime(23, 0),
                'location' => 'Plaza Principal de Umachiri',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Campeonato de Fútbol Intercomunal',
                'description' => 'Torneo de fútbol que reúne a los mejores equipos de la región. Competencia deportiva con premios para los ganadores.',
                'start_time' => Carbon::now()->addDays(8)->setTime(9, 0),
                'end_time' => Carbon::now()->addDays(8)->setTime(17, 0),
                'location' => 'Estadio Municipal',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Feria Gastronómica Regional',
                'description' => 'Muestra de la gastronomía típica de nuestra región. Platos tradicionales preparados por las mejores cocineras locales.',
                'start_time' => Carbon::now()->addDays(22)->setTime(10, 0),
                'end_time' => Carbon::now()->addDays(22)->setTime(20, 0),
                'location' => 'Centro Comunal',
                'image' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Concurso de Danzas Folclóricas',
                'description' => 'Competencia de danzas tradicionales con participación de grupos de toda la provincia. Preservando nuestras tradiciones culturales.',
                'start_time' => Carbon::now()->addDays(30)->setTime(15, 0),
                'end_time' => Carbon::now()->addDays(30)->setTime(21, 0),
                'location' => 'Coliseo Municipal',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Taller de Radio Comunitaria',
                'description' => 'Taller gratuito para jóvenes interesados en aprender sobre producción radiofónica, locución y periodismo comunitario.',
                'start_time' => Carbon::now()->addDays(5)->setTime(14, 0),
                'end_time' => Carbon::now()->addDays(5)->setTime(18, 0),
                'location' => 'Estudios de Radio Stereo Umachiri',
                'image' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Celebración del Día de la Madre',
                'description' => 'Evento especial dedicado a todas las madres de nuestra comunidad con música, bailes y reconocimientos especiales.',
                'start_time' => Carbon::now()->addDays(45)->setTime(16, 0),
                'end_time' => Carbon::now()->addDays(45)->setTime(22, 0),
                'location' => 'Auditorio Municipal',
                'image' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Maratón Solidaria por la Educación',
                'description' => 'Carrera benéfica para recaudar fondos destinados a mejorar la infraestructura educativa de nuestra comunidad.',
                'start_time' => Carbon::now()->addDays(12)->setTime(7, 0),
                'end_time' => Carbon::now()->addDays(12)->setTime(12, 0),
                'location' => 'Circuito urbano de Umachiri',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Noche de Talentos Juveniles',
                'description' => 'Espacio para que los jóvenes muestren sus talentos en música, danza, teatro y otras expresiones artísticas.',
                'start_time' => Carbon::now()->addDays(18)->setTime(19, 0),
                'end_time' => Carbon::now()->addDays(18)->setTime(23, 0),
                'location' => 'Centro Cultural',
                'image' => null,
                'is_featured' => false,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}