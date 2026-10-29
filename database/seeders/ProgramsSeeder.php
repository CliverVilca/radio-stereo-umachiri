<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramsSeeder extends Seeder
{
    public function run()
    {
        $programs = [
            [
                'title' => 'Buenos Días Umachiri',
                'description' => 'Programa matutino con noticias locales, música y entretenimiento para comenzar el día con energía.',
                'host' => 'María González',
                'days_of_week' => ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
                'start_time' => '06:00',
                'end_time' => '09:00',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Música del Recuerdo',
                'description' => 'Los mejores éxitos de ayer y hoy. Música que marcó generaciones y sigue emocionando.',
                'host' => 'Carlos Mendoza',
                'days_of_week' => ['Lunes', 'Miércoles', 'Viernes'],
                'start_time' => '15:00',
                'end_time' => '17:00',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Deportes en Acción',
                'description' => 'Toda la información deportiva local y nacional. Resultados, análisis y entrevistas.',
                'host' => 'Roberto Silva',
                'days_of_week' => ['Martes', 'Jueves', 'Sábado'],
                'start_time' => '18:00',
                'end_time' => '19:00',
                'image' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Noches de Cumbia',
                'description' => 'La mejor cumbia peruana y latinoamericana para bailar y disfrutar en familia.',
                'host' => 'Ana Quispe',
                'days_of_week' => ['Viernes', 'Sábado'],
                'start_time' => '20:00',
                'end_time' => '22:00',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Conexión Juvenil',
                'description' => 'Programa dirigido a los jóvenes con música actual, tecnología y temas de interés.',
                'host' => 'Luis Mamani',
                'days_of_week' => ['Sábado', 'Domingo'],
                'start_time' => '16:00',
                'end_time' => '18:00',
                'image' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Tradiciones de Nuestra Tierra',
                'description' => 'Rescatando las costumbres, música folclórica y tradiciones de nuestra región.',
                'host' => 'Carmen Flores',
                'days_of_week' => ['Domingo'],
                'start_time' => '10:00',
                'end_time' => '12:00',
                'image' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Informativo Central',
                'description' => 'Las noticias más importantes del día a nivel local, nacional e internacional.',
                'host' => 'Pedro Huanca',
                'days_of_week' => ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
                'start_time' => '12:00',
                'end_time' => '13:00',
                'image' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Serenata Dominical',
                'description' => 'Música romántica y baladas para acompañar tu domingo en familia.',
                'host' => 'Rosa Mamani',
                'days_of_week' => ['Domingo'],
                'start_time' => '14:00',
                'end_time' => '16:00',
                'image' => null,
                'is_featured' => false,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}