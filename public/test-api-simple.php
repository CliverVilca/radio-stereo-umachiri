<?php
// Simple test to verify API connectivity
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization');

// Include Laravel bootstrap
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    // Test database connection
    $newsCount = \App\Models\News::count();
    
    // Test API endpoint
    $news = \App\Models\News::take(3)->get();
    
    echo json_encode([
        'success' => true,
        'message' => 'API funcionando correctamente',
        'data' => [
            'news_count' => $newsCount,
            'sample_news' => $news->toArray()
        ]
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>