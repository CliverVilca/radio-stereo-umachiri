<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\News;

echo "=== DIAGNÓSTICO DE NOTICIAS PÚBLICAS ===\n\n";

echo "1. TODAS LAS NOTICIAS EN LA BASE DE DATOS:\n";
echo "==========================================\n";
$allNews = News::all();
foreach ($allNews as $news) {
    echo "ID: {$news->id}\n";
    echo "Título: {$news->title}\n";
    echo "Estado: {$news->status}\n";
    echo "Fecha publicación: " . ($news->published_at ?? 'NULL') . "\n";
    echo "Imagen: " . ($news->image ?? 'NULL') . "\n";
    if ($news->image) {
        $imagePath = public_path("images/{$news->image}");
        echo "Archivo existe: " . (file_exists($imagePath) ? '✅ SÍ' : '❌ NO') . "\n";
    }
    echo "---\n";
}

echo "\n2. NOTICIAS QUE SE MUESTRAN EN LA PÁGINA PÚBLICA:\n";
echo "================================================\n";
$publicNews = News::where('status', 'published')
                  ->where('published_at', '<=', now())
                  ->orderBy('published_at', 'desc')
                  ->get();

echo "Total de noticias públicas: " . $publicNews->count() . "\n\n";

foreach ($publicNews as $news) {
    echo "ID: {$news->id}\n";
    echo "Título: {$news->title}\n";
    echo "Estado: {$news->status}\n";
    echo "Fecha publicación: {$news->published_at}\n";
    echo "Imagen: " . ($news->image ?? 'NULL') . "\n";
    if ($news->image) {
        echo "URL imagen: /images/{$news->image}\n";
        $imagePath = public_path("images/{$news->image}");
        echo "Archivo existe: " . (file_exists($imagePath) ? '✅ SÍ' : '❌ NO') . "\n";
    }
    echo "---\n";
}

echo "\n3. VERIFICACIÓN DE DIRECTORIO DE IMÁGENES:\n";
echo "==========================================\n";
$imagesDir = public_path('images/news');
echo "Directorio: {$imagesDir}\n";
echo "Existe: " . (is_dir($imagesDir) ? '✅ SÍ' : '❌ NO') . "\n";

if (is_dir($imagesDir)) {
    $files = scandir($imagesDir);
    $imageFiles = array_filter($files, function($file) {
        return !in_array($file, ['.', '..']);
    });
    echo "Archivos encontrados: " . count($imageFiles) . "\n";
    foreach ($imageFiles as $file) {
        echo "  - {$file}\n";
    }
}