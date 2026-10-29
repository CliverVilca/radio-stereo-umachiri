<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sport;
use Carbon\Carbon;

class SportsSeeder extends Seeder
{
    public function run()
    {
        $sports = [
            [
                'title' => 'Campeonato Local de Fútbol 2024',
                'content' => '<p>El campeonato local de fútbol ha comenzado con gran entusiasmo en nuestra comunidad. Los equipos participantes han mostrado un nivel competitivo excepcional.</p><p>Los partidos se realizan todos los fines de semana en el estadio municipal, con una gran asistencia de público que apoya a sus equipos favoritos.</p><p>Hasta el momento, el equipo "Los Cóndores" lidera la tabla de posiciones con 15 puntos, seguido de cerca por "Águilas Doradas" con 12 puntos.</p>',
                'author' => 'Carlos Mendoza',
                'category' => 'futbol',
                'status' => 'published',
                'is_featured' => true,
                'image' => null,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Torneo de Vóley Femenino',
                'content' => '<p>Las mujeres de nuestra comunidad han demostrado su talento deportivo en el torneo de vóley que se desarrolla en el coliseo municipal.</p><p>Participan 8 equipos de diferentes barrios, mostrando un nivel técnico muy alto y un espíritu deportivo ejemplar.</p><p>El torneo se realiza todos los martes y jueves por la tarde, con entrada libre para todo el público.</p>',
                'author' => 'María González',
                'category' => 'voleibol',
                'status' => 'published',
                'is_featured' => false,
                'image' => null,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Maratón Anual de Umachiri',
                'content' => '<p>Se acerca la fecha del maratón anual de Umachiri, evento que convoca a corredores de toda la región.</p><p>La carrera de 10K recorrerá las principales calles del pueblo, comenzando en la plaza principal y terminando en el estadio municipal.</p><p>Las inscripciones están abiertas hasta el 15 de este mes. Los premios incluyen trofeos y medallas para los primeros lugares en cada categoría.</p>',
                'author' => 'Roberto Silva',
                'category' => 'atletismo',
                'status' => 'published',
                'is_featured' => true,
                'image' => null,
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Liga Juvenil de Básquet',
                'content' => '<p>Los jóvenes de Umachiri han formado una liga de básquet que promete ser muy emocionante.</p><p>Participan equipos de las diferentes instituciones educativas del distrito, fomentando el deporte y la sana competencia entre los estudiantes.</p><p>Los partidos se realizan los sábados por la mañana en la cancha del colegio secundario.</p>',
                'author' => 'Ana Quispe',
                'category' => 'basquet',
                'status' => 'published',
                'is_featured' => false,
                'image' => null,
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Campeonato de Ciclismo de Montaña',
                'content' => '<p>El próximo mes se realizará el campeonato de ciclismo de montaña en los alrededores de Umachiri.</p><p>La ruta incluye senderos desafiantes con vistas espectaculares del paisaje andino, atrayendo a ciclistas de diferentes regiones.</p><p>Se han establecido tres categorías: principiantes, intermedio y avanzado, para que todos puedan participar según su nivel.</p>',
                'author' => 'Luis Mamani',
                'category' => 'otros',
                'status' => 'published',
                'is_featured' => false,
                'image' => null,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Torneo de Ping Pong Comunitario',
                'content' => '<p>El centro comunal alberga el torneo de ping pong que ha despertado gran interés entre los vecinos.</p><p>Participan desde niños hasta adultos mayores, creando un ambiente familiar y divertido.</p><p>Las finales se realizarán el próximo domingo con premiación para todos los participantes.</p>',
                'author' => 'Carmen Flores',
                'category' => 'otros',
                'status' => 'published',
                'is_featured' => false,
                'image' => null,
                'published_at' => Carbon::now()->subDays(4),
            ],
        ];

        foreach ($sports as $sport) {
            Sport::create($sport);
        }
    }
}