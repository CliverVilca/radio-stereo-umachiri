<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$databases = DB::select('SHOW DATABASES');
foreach ($databases as $dbRow) {
    $db = array_values((array)$dbRow)[0];
    if (in_array($db, ['information_schema', 'performance_schema', 'mysql', 'sys'])) continue;
    
    try {
        $count = DB::table("$db.news")->count();
        if ($count == 9) {
            echo "MATCH FOUND! Database [$db] has 9 news rows.\n";
        } else {
            echo "Database [$db] news count: $count\n";
        }
    } catch (\Exception $e) {
        // Table not found
    }
}
