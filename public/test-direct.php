<?php
// Test directo de la API sin usar rutas de Laravel
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization');

// Incluir Laravel
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    // Simular una request
    $request = \Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    
    // Test básico de conexión a BD
    $newsCount = \App\Models\News::count();
    $sportsCount = \App\Models\Sport::count();
    $eventsCount = \App\Models\Event::count();
    $programsCount = \App\Models\Program::count();
    
    // Obtener algunas noticias
    $news = \App\Models\News::latest()->take(5)->get();
    
    $result = [
        'success' => true,
        'message' => 'API funcionando correctamente',
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => [
            'stats' => [
                'news_count' => $newsCount,
                'sports_count' => $sportsCount,
                'events_count' => $eventsCount,
                'programs_count' => $programsCount,
            ],
            'recent_news' => $news->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'author' => $item->author,
                    'status' => $item->status,
                    'type' => $item->type,
                    'published_at' => $item->published_at,
                    'content_preview' => substr($item->content, 0, 100) . '...'
                ];
            })
        ]
    ];
    
    echo json_encode($result, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], JSON_PRETTY_PRINT);
}
?>