<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\News;

echo "=== ASIGNANDO IMÁGENES FALTANTES ===\n\n";

// Asignar imágenes a las noticias sin imagen
$updates = [
    5 => 'news/1.jpg',  // Inauguración de nueva temporada
    6 => 'news/2.jpg',  // Nuevo programa de música folclórica
];

foreach ($updates as $id => $imagePath) {
    $news = News::find($id);
    if ($news && !$news->image) {
        $news->image = $imagePath;
        $news->save();
        echo "✅ Noticia {$id} ({$news->title}) actualizada con imagen: {$imagePath}\n";
    }
}

echo "\n=== VERIFICACIÓN FINAL ===\n";
$publicNews = News::where('status', 'published')
                  ->where('published_at', '<=', now())
                  ->orderBy('published_at', 'desc')
                  ->take(5)
                  ->get();

foreach ($publicNews as $news) {
    echo "ID: {$news->id} - {$news->title}\n";
    echo "Imagen: " . ($news->image ?? 'NULL') . "\n";
    if ($news->image) {
        $imagePath = public_path("images/{$news->image}");
        echo "Archivo existe: " . (file_exists($imagePath) ? '✅ SÍ' : '❌ NO') . "\n";
    }
    echo "---\n";
}

echo "\n🎉 Proceso completado!\n";