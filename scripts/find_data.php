<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $databases = DB::select('SHOW DATABASES');
    foreach ($databases as $dbRow) {
        $db = array_values((array)$dbRow)[0];
        if (in_array($db, ['information_schema', 'performance_schema', 'mysql', 'sys'])) continue;
        
        try {
            $newsCount = DB::table("$db.news")->count();
            echo "Database [$db] has news table with $newsCount rows.\n";
        } catch (\Exception $e) {
            // Table doesn't exist or no access
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
