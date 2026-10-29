<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GalleriesSeeder extends Seeder
{
    public function run()
    {
        $galleries = [
            [
                'title' => 'Festival de Música Andina 2024',
                'description' => 'Momentos destacados del gran festival de música andina con artistas locales y regionales. Una celebración de nuestra cultura musical.',
                'images' => [
                    'galleries/festival-andino-1.jpg',
                    'galleries/festival-andino-2.jpg',
                    'galleries/festival-andino-3.jpg',
                    'galleries/festival-andino-4.jpg',
                    'galleries/festival-andino-5.jpg',
                ],
                'is_featured' => true,
            ],
            [
                'title' => 'Inauguración de Nuevos Estudios',
                'description' => 'Fotos de la inauguración de nuestros nuevos estudios de radio con tecnología de última generación.',
                'images' => [
                    'galleries/estudios-1.jpg',
                    'galleries/estudios-2.jpg',
                    'galleries/estudios-3.jpg',
                ],
                'is_featured' => true,
            ],
            [
                'title' => 'Campeonato de Fútbol Intercomunal',
                'description' => 'Las mejores jugadas y momentos del campeonato de fútbol que reunió a los equipos de toda la región.',
                'images' => [
                    'galleries/futbol-1.jpg',
                    'galleries/futbol-2.jpg',
                    'galleries/futbol-3.jpg',
                    'galleries/futbol-4.jpg',
                ],
                'is_featured' => false,
            ],
            [
                'title' => 'Feria Gastronómica Regional',
                'description' => 'Deliciosos platos tradicionales y la alegría de nuestra feria gastronómica anual.',
                'images' => [
                    'galleries/gastronomia-1.jpg',
                    'galleries/gastronomia-2.jpg',
                    'galleries/gastronomia-3.jpg',
                    'galleries/gastronomia-4.jpg',
                    'galleries/gastronomia-5.jpg',
                    'galleries/gastronomia-6.jpg',
                ],
                'is_featured' => true,
            ],
            [
                'title' => 'Concurso de Danzas Folclóricas',
                'description' => 'Coloridos trajes y danzas tradicionales en nuestro concurso anual de folclore.',
                'images' => [
                    'galleries/danzas-1.jpg',
                    'galleries/danzas-2.jpg',
                    'galleries/danzas-3.jpg',
                ],
                'is_featured' => false,
            ],
            [
                'title' => 'Celebración del Día de la Madre',
                'description' => 'Emotivos momentos de la celebración dedicada a todas las madres de nuestra comunidad.',
                'images' => [
                    'galleries/dia-madre-1.jpg',
                    'galleries/dia-madre-2.jpg',
                    'galleries/dia-madre-3.jpg',
                    'galleries/dia-madre-4.jpg',
                ],
                'is_featured' => false,
            ],
            [
                'title' => 'Taller de Radio Comunitaria',
                'description' => 'Jóvenes aprendiendo sobre producción radiofónica y periodismo comunitario.',
                'images' => [
                    'galleries/taller-radio-1.jpg',
                    'galleries/taller-radio-2.jpg',
                    'galleries/taller-radio-3.jpg',
                ],
                'is_featured' => false,
            ],
            [
                'title' => 'Noche de Talentos Juveniles',
                'description' => 'Los jóvenes de nuestra comunidad mostrando sus increíbles talentos artísticos.',
                'images' => [
                    'galleries/talentos-1.jpg',
                    'galleries/talentos-2.jpg',
                    'galleries/talentos-3.jpg',
                    'galleries/talentos-4.jpg',
                    'galleries/talentos-5.jpg',
                ],
                'is_featured' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}