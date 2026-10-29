<?php
/**
 * Script para solucionar problemas de visualización de imágenes
 */

echo "🔧 Solucionando problemas de visualización de imágenes\n";
echo "=====================================================\n\n";

// Verificar directorios
$storage_path = __DIR__ . '/storage/app/public';
$public_storage_path = __DIR__ . '/public/storage';

echo "📁 Verificando directorios:\n";
echo "Storage path: $storage_path\n";
echo "Public storage path: $public_storage_path\n\n";

// Verificar si existe el directorio de almacenamiento
if (!is_dir($storage_path)) {
    echo "❌ El directorio de almacenamiento no existe. Creándolo...\n";
    mkdir($storage_path, 0755, true);
} else {
    echo "✅ Directorio de almacenamiento existe\n";
}

// Listar contenido del directorio de almacenamiento
echo "\n📂 Contenido del directorio de almacenamiento:\n";
$storage_contents = scandir($storage_path);
foreach ($storage_contents as $item) {
    if ($item !== '.' && $item !== '..') {
        $item_path = $storage_path . DIRECTORY_SEPARATOR . $item;
        if (is_dir($item_path)) {
            $count = count(glob($item_path . '/*')) - 2; // Excluir . y ..
            echo "📁 $item/ ($count archivos)\n";
        } else {
            echo "📄 $item\n";
        }
    }
}

// Verificar enlace simbólico
echo "\n🔗 Verificando enlace simbólico:\n";
if (is_link($public_storage_path)) {
    echo "✅ Enlace simbólico existe\n";
    echo "Apunta a: " . readlink($public_storage_path) . "\n";
} else if (is_dir($public_storage_path)) {
    echo "⚠️  Existe un directorio en lugar de enlace simbólico\n";
} else {
    echo "❌ No existe enlace simbólico\n";
}

// En Windows, crear una copia física si el enlace simbólico no funciona
if (PHP_OS_FAMILY === 'Windows') {
    echo "\n🪟 Sistema Windows detectado - Creando copia física de archivos\n";
    
    // Función recursiva para copiar directorios
    function copyDirectory($src, $dst) {
        if (!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }
        
        $files = scandir($src);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $srcFile = $src . DIRECTORY_SEPARATOR . $file;
                $dstFile = $dst . DIRECTORY_SEPARATOR . $file;
                
                if (is_dir($srcFile)) {
                    copyDirectory($srcFile, $dstFile);
                } else {
                    copy($srcFile, $dstFile);
                }
            }
        }
    }
    
    // Eliminar directorio público si existe
    if (is_dir($public_storage_path)) {
        function deleteDirectory($dir) {
            if (!is_dir($dir)) return;
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $dir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($filePath)) {
                        deleteDirectory($filePath);
                    } else {
                        unlink($filePath);
                    }
                }
            }
            rmdir($dir);
        }
        
        deleteDirectory($public_storage_path);
    }
    
    // Copiar archivos
    copyDirectory($storage_path, $public_storage_path);
    echo "✅ Archivos copiados a public/storage\n";
}

// Verificar algunas imágenes específicas
echo "\n🖼️  Verificando imágenes específicas:\n";

$image_dirs = ['news', 'galleries', 'events', 'programs'];
foreach ($image_dirs as $dir) {
    $dir_path = $storage_path . DIRECTORY_SEPARATOR . $dir;
    if (is_dir($dir_path)) {
        $images = glob($dir_path . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
        echo "📁 $dir: " . count($images) . " imágenes\n";
        
        // Mostrar las primeras 3 imágenes
        for ($i = 0; $i < min(3, count($images)); $i++) {
            $image_name = basename($images[$i]);
            $public_url = "/storage/$dir/$image_name";
            echo "   - $image_name -> $public_url\n";
        }
    }
}

// Crear un archivo de prueba
echo "\n🧪 Creando archivo de prueba:\n";
$test_file = $storage_path . DIRECTORY_SEPARATOR . 'test.txt';
file_put_contents($test_file, 'Test file created at ' . date('Y-m-d H:i:s'));

if (PHP_OS_FAMILY === 'Windows') {
    $public_test_file = $public_storage_path . DIRECTORY_SEPARATOR . 'test.txt';
    copy($test_file, $public_test_file);
}

echo "✅ Archivo de prueba creado\n";
echo "URL de prueba: /storage/test.txt\n";

echo "\n✨ Proceso completado!\n";
echo "===================\n";
echo "🌐 Las imágenes deberían estar disponibles en: /storage/[carpeta]/[imagen]\n";
echo "📱 Ejemplo: /storage/news/imagen.jpg\n";
echo "🔄 Si sigues teniendo problemas, ejecuta este script nuevamente\n";