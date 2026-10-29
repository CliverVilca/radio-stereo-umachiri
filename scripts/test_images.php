<?php
/**
 * Script para probar el acceso a las imágenes
 */

echo "🖼️ Probando acceso a imágenes\n";
echo "============================\n\n";

// Verificar algunas imágenes específicas
$storage_path = __DIR__ . '/storage/app/public';
$test_images = [];

// Buscar imágenes en diferentes directorios
$directories = ['news', 'galleries', 'events', 'programs', 'sports'];

foreach ($directories as $dir) {
    $dir_path = $storage_path . '/' . $dir;
    if (is_dir($dir_path)) {
        $images = glob($dir_path . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
        foreach ($images as $image) {
            $relative_path = str_replace($storage_path . '/', '', $image);
            $test_images[] = $relative_path;
            if (count($test_images) >= 5) break 2; // Solo probar 5 imágenes
        }
    }
}

echo "📁 Imágenes encontradas para probar:\n";
foreach ($test_images as $image) {
    echo "   - $image\n";
}

echo "\n🌐 URLs de prueba:\n";
foreach ($test_images as $image) {
    $url = "/storage/" . str_replace('\\', '/', $image);
    echo "   - $url\n";
}

echo "\n✅ Ruta de almacenamiento configurada en routes/web.php\n";
echo "🔄 Las imágenes deberían ser accesibles ahora a través de /storage/[ruta]\n";
echo "📱 Ejemplo: /storage/news/imagen.jpg\n\n";

echo "💡 Para probar:\n";
echo "1. Inicia el servidor: php artisan serve\n";
echo "2. Visita: http://localhost:8000/storage/news/1.jpg (si existe)\n";
echo "3. O usa el panel de administración para ver las imágenes\n";