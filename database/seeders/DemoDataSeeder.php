<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedNews();
        $this->seedSports();
        $this->seedDjs();
        $this->seedPrograms();
        $this->seedEvents();
        $this->seedGalleries();
        $this->seedComments();
        $this->command->info('✅ Demo data seeded — 5 records per section.');
    }

    // ─── NOTICIAS ────────────────────────────────────────────────────────────
    private function seedNews(): void
    {
        $items = [
            [
                'title'        => 'Umachiri celebra aniversario con gran feria cultural',
                'content'      => 'La ciudad de Umachiri se prepara para celebrar un nuevo aniversario con una vistosa feria cultural que reunirá a artistas locales, artesanos y grupos de danza típica de la región de Melgar. Las actividades comenzarán a las 9 de la mañana en la Plaza Principal y se extenderán hasta la noche con shows musicales en vivo.',
                'author'       => 'Redacción Stereo Umachiri',
                'type'         => 'local',
                'status'       => 'published',
                'published_at' => Carbon::now()->subDays(1),
                'is_featured'  => 1,
            ],
            [
                'title'        => 'Nuevo proyecto de agua potable beneficiará a 3 000 familias',
                'content'      => 'El gobierno regional de Puno anunció la aprobación de un proyecto de agua potable que beneficiará a más de 3 000 familias del distrito de Umachiri. La obra tendrá una inversión de 12 millones de soles y se espera que inicie en el primer trimestre del próximo año.',
                'author'       => 'Carlos Mamani Quispe',
                'type'         => 'local',
                'status'       => 'published',
                'published_at' => Carbon::now()->subDays(3),
                'is_featured'  => 0,
            ],
            [
                'title'        => 'Feria agropecuaria de Melgar bate récord de participantes',
                'content'      => 'La tradicional Feria Agropecuaria de la provincia de Melgar registró este año más de 450 expositores provenientes de todas las comunidades de la región, superando el récord histórico de participación. La venta de ganado alpacuno y vacuno superó los 2 millones de soles en transacciones.',
                'author'       => 'Rosa Condori',
                'type'         => 'local',
                'status'       => 'published',
                'published_at' => Carbon::now()->subDays(5),
                'is_featured'  => 0,
            ],
            [
                'title'        => 'Peru clasifica al Mundial Sub-20 tras vencer a Ecuador',
                'content'      => 'La selección peruana Sub-20 clasificó al Campeonato Mundial de la categoría tras derrotar a Ecuador por 2-1 en el estadio Nacional de Lima. Los goles fueron marcados por Alessandro Burlamaqui y Sebastián García.',
                'author'       => 'Deportes Umachiri',
                'type'         => 'internacional',
                'status'       => 'published',
                'published_at' => Carbon::now()->subDays(2),
                'is_featured'  => 0,
            ],
            [
                'title'        => 'Inauguran nueva carretera que une Umachiri con Ayaviri',
                'content'      => 'Las autoridades de la Municipalidad de Umachiri y el Ministerio de Transportes inauguraron la nueva carretera asfaltada que une el distrito con la capital provincial de Ayaviri. La obra, de 28 kilómetros de extensión, reducirá el tiempo de viaje de 2 horas a sólo 35 minutos.',
                'author'       => 'Redacción Stereo Umachiri',
                'type'         => 'local',
                'status'       => 'published',
                'published_at' => Carbon::now()->subDays(7),
                'is_featured'  => 1,
            ],
        ];

        foreach ($items as $item) {
            \App\Models\News::create($item);
        }
        $this->command->line('  → Noticias: 5');
    }

    // ─── DEPORTES ─────────────────────────────────────────────────────────────
    private function seedSports(): void
    {
        $items = [
            [
                'title'        => 'Umachiri FC golea 4-0 en la Liga Distrital de Melgar',
                'content'      => 'El equipo de fútbol Umachiri FC logró una contundente victoria por 4-0 ante Ayaviri Sporting en la cuarta fecha de la Liga Distrital de Melgar. Los goles fueron de Juan Huanca (2), Pedro Ticona y Raúl Cusi. Con este resultado, el equipo lidera la tabla de posiciones.',
                'author'       => 'Deportes Radio Stereo',
                'category'     => 'futbol',
                'published_at' => Carbon::now()->subDays(1),
                'status'       => 'published',
                'is_featured'  => 1,
            ],
            [
                'title'        => 'Atletas de Umachiri destacan en los Juegos Regionales de Puno',
                'content'      => 'Cuatro atletas del distrito de Umachiri obtuvieron medallas de oro, plata y bronce en los Juegos Regionales celebrados en la ciudad de Puno. María Quispe se coronó campeona en los 800 metros planos con un tiempo de 2:14:03.',
                'author'       => 'Ángel Coaquira',
                'category'     => 'atletismo',
                'published_at' => Carbon::now()->subDays(3),
                'status'       => 'published',
                'is_featured'  => 0,
            ],
            [
                'title'        => 'Torneo de vóley femenino reúne a 12 equipos de la provincia',
                'content'      => 'El polideportivo de Umachiri acogió el primer torneo de vóley femenino de la provincia de Melgar, con la participación de 12 equipos de diferentes distritos. El equipo anfitrión llegó hasta la final, donde perdió por 3-2 ante el equipo de Santa Rosa.',
                'author'       => 'Redacción Deportiva',
                'category'     => 'voley',
                'published_at' => Carbon::now()->subDays(5),
                'status'       => 'published',
                'is_featured'  => 0,
            ],
            [
                'title'        => 'Selección peruana de básquet clasifica al Sudamericano',
                'content'      => 'La selección peruana de baloncesto masculino logró su clasificación al Campeonato Sudamericano FIBA tras superar la fase de clasificación con 5 victorias y 1 derrota. Perú se enfrentará a Argentina, Chile y Uruguay en la fase de grupos.',
                'author'       => 'Deportes Stereo',
                'category'     => 'basquet',
                'published_at' => Carbon::now()->subDays(2),
                'status'       => 'published',
                'is_featured'  => 0,
            ],
            [
                'title'        => 'Copa Melgar 2026: Arrancan los cuartos de final',
                'content'      => 'La Copa Melgar entra en su fase más emocionante con los cuartos de final programados para el próximo fin de semana. Los equipos clasificados son: Umachiri FC, Ayaviri Sporting, Ñuñoa Campeones y Santa Rosa United. Los partidos se disputarán en el Estadio Municipal.',
                'author'       => 'Ángel Coaquira',
                'category'     => 'futbol',
                'published_at' => Carbon::now()->subDays(4),
                'status'       => 'published',
                'is_featured'  => 1,
            ],
        ];

        foreach ($items as $item) {
            \App\Models\Sport::create($item);
        }
        $this->command->line('  → Deportes: 5');
    }

    // ─── DJS ──────────────────────────────────────────────────────────────────
    private function seedDjs(): void
    {
        $items = [
            [
                'name'       => 'Juan Carlos Huanca',
                'specialty'  => 'Noticias y actualidad regional',
                'bio'        => 'Periodista con más de 15 años de experiencia en medios de comunicación de la región Puno. Conduce el informativo matutino de Stereo Umachiri y es la voz más reconocida de la emisora.',
                'photo_path' => '',
                'email'      => 'jhuanca@stereumachiri.pe',
            ],
            [
                'name'       => 'Rosa Mamani Ticona',
                'specialty'  => 'Folklore y música andina',
                'bio'        => 'Locutora especializada en música folklórica puneña. Lleva 8 años difundiendo la cultura andina a través de sus programas de huayno, marinera norteña y música autóctona de los Andes.',
                'photo_path' => '',
                'email'      => 'rmamani@stereumachiri.pe',
            ],
            [
                'name'       => 'Pedro Coaquira Flores',
                'specialty'  => 'Deporte y comentarista',
                'bio'        => 'Ex futbolista del equipo distrital de Umachiri, hoy convertido en el principal comentarista deportivo de la radio. Cubre todos los eventos deportivos de la provincia de Melgar.',
                'photo_path' => '',
                'email'      => 'pcoaquira@stereumachiri.pe',
            ],
            [
                'name'       => 'Lucía Quispe Ramos',
                'specialty'  => 'Cumbia, salsa y música tropical',
                'bio'        => 'La voz más alegre de Stereo Umachiri. Conduce el programa nocturno de música tropical y es la favorita del público joven de la región. Cantante aficionada con varios años en el ambiente musical puneño.',
                'photo_path' => '',
                'email'      => 'lquispe@stereumachiri.pe',
            ],
            [
                'name'       => 'Marcos Condori Velásquez',
                'specialty'  => 'Agropecuario y comunidades',
                'bio'        => 'Ingeniero agrónomo y locutor rural. Conduce el programa de orientación agropecuaria más escuchado del distrito, brindando información sobre precios de mercado, técnicas de cultivo y noticias del campo.',
                'photo_path' => '',
                'email'      => 'mcondori@stereumachiri.pe',
            ],
        ];

        foreach ($items as $item) {
            \App\Models\Dj::create($item);
        }
        $this->command->line('  → DJs: 5');
    }

    // ─── PROGRAMAS ───────────────────────────────────────────────────────────
    private function seedPrograms(): void
    {
        $items = [
            [
                'title'       => 'Despertar Umachiri',
                'description' => 'El informativo matutino que te da las noticias locales, regionales y nacionales para comenzar el día bien informado.',
                'host'        => 'Juan Carlos Huanca',
                'days_of_week'=> ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
                'start_time'  => '06:00',
                'end_time'    => '08:00',
                'is_featured' => 1,
            ],
            [
                'title'       => 'Folklore al Máximo',
                'description' => 'La mejor selección de música folklórica andina: huaynos, marineras, carnavales y música autóctona de Puno y los Andes del Perú.',
                'host'        => 'Rosa Mamani Ticona',
                'days_of_week'=> ['Lunes', 'Miércoles', 'Viernes'],
                'start_time'  => '10:00',
                'end_time'    => '12:00',
                'is_featured' => 1,
            ],
            [
                'title'       => 'Tarde Deportiva',
                'description' => 'Las noticias deportivas locales, los resultados de la Liga Distrital y el análisis de los grandes partidos nacionales e internacionales.',
                'host'        => 'Pedro Coaquira Flores',
                'days_of_week'=> ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                'start_time'  => '14:00',
                'end_time'    => '15:30',
                'is_featured' => 0,
            ],
            [
                'title'       => 'Tropical Nights',
                'description' => 'El mejor ambiente nocturno con cumbia, salsa, bachata y los éxitos tropicales más escuchados. El programa para bailar y disfrutar.',
                'host'        => 'Lucía Quispe Ramos',
                'days_of_week'=> ['Viernes', 'Sábado'],
                'start_time'  => '20:00',
                'end_time'    => '23:00',
                'is_featured' => 0,
            ],
            [
                'title'       => 'Campo y Comunidad',
                'description' => 'Programa de orientación agropecuaria: precios del mercado, técnicas de cultivo, crianza de alpacas y noticias de las comunidades campesinas.',
                'host'        => 'Marcos Condori Velásquez',
                'days_of_week'=> ['Martes', 'Jueves', 'Sábado'],
                'start_time'  => '08:00',
                'end_time'    => '09:30',
                'is_featured' => 0,
            ],
        ];

        $programs = [];
        foreach ($items as $item) {
            $programs[] = \App\Models\Program::create($item);
        }

        // Añadir 2-3 podcasts por programa
        $podcastTitles = [
            ['Noticias del lunes — Top 5 historias locales', 'Especial: Aniversario de Umachiri', 'Entrevista al alcalde distrital'],
            ['Los mejores huaynos de Melgar Vol.1', 'Carnavales Puneños — selección especial', 'Música de Semana Santa'],
            ['Resumen deportivo — Copa Melgar Fecha 4', 'Entrevista: María Quispe campeona regional', 'Análisis: Umachiri FC en la Liga'],
            ['Mix tropical — Viernes de baile', 'Éxitos de cumbia peruana 2025', 'Salsa en la noche de Umachiri'],
            ['Precio de la alpaca — enero 2026', 'Técnicas de cultivo de papa nativa', 'Feria agropecuaria — guía del expositor'],
        ];

        foreach ($programs as $i => $prog) {
            foreach ($podcastTitles[$i] as $j => $ptitle) {
                \App\Models\Podcast::create([
                    'program_id'   => $prog->id,
                    'title'        => $ptitle,
                    'description'  => 'Episodio del programa ' . $prog->title . ' — escucha completo en Stereo Umachiri 98.5 FM.',
                    'audio_file'   => null,
                    'published_at' => Carbon::now()->subDays(($j + 1) * 3),
                ]);
            }
        }

        $this->command->line('  → Programas: 5 + Podcasts: 15');
    }

    // ─── EVENTOS ─────────────────────────────────────────────────────────────
    private function seedEvents(): void
    {
        $items = [
            [
                'title'       => 'Aniversario de Umachiri — Noche Artística',
                'description' => 'Gran noche artística por el aniversario del distrito de Umachiri. Se presentarán grupos de danza, cantantes folklóricos y el huaylarsh de la región. Entrada libre para toda la familia.',
                'start_time'  => Carbon::now()->addDays(7)->setTime(19, 0),
                'end_time'    => Carbon::now()->addDays(7)->setTime(23, 0),
                'location'    => 'Plaza Principal de Umachiri',
                'is_featured' => 1,
            ],
            [
                'title'       => 'Feria Agropecuaria Distrital 2026',
                'description' => 'La tradicional Feria Agropecuaria donde los productores del distrito exhibirán y venderán ganado vacuno, alpacuno y ovino. También habrá exposición de productos agrícolas y artesanías.',
                'start_time'  => Carbon::now()->addDays(14)->setTime(8, 0),
                'end_time'    => Carbon::now()->addDays(14)->setTime(17, 0),
                'location'    => 'Campo Ferial Municipal, Umachiri',
                'is_featured' => 1,
            ],
            [
                'title'       => 'Final Copa Melgar 2026 — Fútbol',
                'description' => 'La gran final de la Copa Melgar 2026 entre los dos mejores equipos de la provincia. Entrada general: S/ 5.00. Tribunas reservadas: S/ 10.00. No te pierdas el partido del año.',
                'start_time'  => Carbon::now()->addDays(21)->setTime(15, 0),
                'end_time'    => Carbon::now()->addDays(21)->setTime(17, 30),
                'location'    => 'Estadio Municipal de Ayaviri',
                'is_featured' => 0,
            ],
            [
                'title'       => 'Festival de Música Andina — San Juan 2026',
                'description' => 'El festival más esperado del año reúne a los mejores grupos de música andina de Puno, Cusco y Arequipa. Tres escenarios, más de 20 agrupaciones y fuegos artificiales al final de la noche.',
                'start_time'  => Carbon::now()->addDays(45)->setTime(10, 0),
                'end_time'    => Carbon::now()->addDays(45)->setTime(22, 0),
                'location'    => 'Coliseo Cerrado de Melgar, Ayaviri',
                'is_featured' => 1,
            ],
            [
                'title'       => 'Capacitación: Crianza tecnificada de alpacas',
                'description' => 'Talleres gratuitos de crianza tecnificada de alpacas, esquila, clasificación de fibra y comercialización. Dirigido a productores alpaqueros de la provincia de Melgar. Inscripciones en el municipio.',
                'start_time'  => Carbon::now()->addDays(10)->setTime(9, 0),
                'end_time'    => Carbon::now()->addDays(10)->setTime(13, 0),
                'location'    => 'Auditorio Municipal de Umachiri',
                'is_featured' => 0,
            ],
        ];

        foreach ($items as $item) {
            \App\Models\Event::create($item);
        }
        $this->command->line('  → Eventos: 5');
    }

    // ─── GALERÍAS ────────────────────────────────────────────────────────────
    private function seedGalleries(): void
    {
        $items = [
            [
                'title'       => 'Aniversario Umachiri 2025',
                'description' => 'Fotografías del desfile cívico militar y la noche artística por el aniversario del distrito de Umachiri.',
                'images'      => [],
                'is_featured' => 1,
            ],
            [
                'title'       => 'Feria Agropecuaria 2025',
                'description' => 'Imágenes de la Feria Agropecuaria Distrital: exposición de ganadería, artesanías y productos locales.',
                'images'      => [],
                'is_featured' => 0,
            ],
            [
                'title'       => 'Carnavales de Orurillo 2026',
                'description' => 'La fiesta de carnavales en el distrito vecino de Orurillo con coloridos trajes, comparsas y música típica.',
                'images'      => [],
                'is_featured' => 1,
            ],
            [
                'title'       => 'Copa Melgar — Fotos del torneo',
                'description' => 'Galería de imágenes de los partidos de la Copa Melgar 2025. Acción, goles y la celebración del campeón.',
                'images'      => [],
                'is_featured' => 0,
            ],
            [
                'title'       => 'Estudio de Stereo Umachiri',
                'description' => 'Conoce las instalaciones del estudio de Radio Stereo Umachiri 98.5 FM, nuestra cabina, equipos y el equipo humano.',
                'images'      => [],
                'is_featured' => 0,
            ],
        ];

        foreach ($items as $item) {
            \App\Models\Gallery::create($item);
        }
        $this->command->line('  → Galerías: 5');
    }

    // ─── COMENTARIOS ─────────────────────────────────────────────────────────
    private function seedComments(): void
    {
        // Necesitamos al menos una noticia
        $firstNews = \App\Models\News::first();
        if (!$firstNews) {
            $this->command->line('  → Comentarios: saltados (no hay noticias)');
            return;
        }

        $newsIds = \App\Models\News::pluck('id')->toArray();

        $items = [
            [
                'news_id'  => $newsIds[0] ?? $firstNews->id,
                'name'     => 'María Elena Quispe',
                'content'  => 'Muy buena noticia para nuestra comunidad. Esperemos que el proyecto se ejecute pronto y beneficie a todas las familias del distrito.',
                'approved' => true,
            ],
            [
                'news_id'  => $newsIds[0] ?? $firstNews->id,
                'name'     => 'Carlos Huanca Flores',
                'content'  => 'Gracias Stereo Umachiri por mantenernos informados. Es importante saber lo que pasa en nuestra región.',
                'approved' => true,
            ],
            [
                'news_id'  => $newsIds[1] ?? $firstNews->id,
                'name'     => 'Pedro Ticona Mamani',
                'content'  => 'Excelente cobertura de la feria. Mi familia participó y fue una experiencia increíble. Ojalá se repita el próximo año.',
                'approved' => false,  // pendiente
            ],
            [
                'news_id'  => $newsIds[2] ?? $firstNews->id,
                'name'     => 'Lucía Condori',
                'content'  => 'Me alegra mucho ver que Umachiri está progresando. Esta radio siempre nos tiene al tanto de todo. ¡Adelante!',
                'approved' => true,
            ],
            [
                'news_id'  => $newsIds[3] ?? $firstNews->id,
                'name'     => 'Roberto Apaza Turpo',
                'content'  => '¿A qué hora podré escuchar la entrevista completa por la radio? Muy interesante el tema de la carretera nueva.',
                'approved' => false,  // pendiente
            ],
        ];

        foreach ($items as $item) {
            \App\Models\Comment::create($item);
        }
        $this->command->line('  → Comentarios: 5 (3 aprobados, 2 pendientes)');
    }
}
