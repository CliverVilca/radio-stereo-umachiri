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
            $tables = DB::select("SHOW TABLES FROM `$db` ");
            foreach ($tables as $tableRow) {
                $table = array_values((array)$tableRow)[0];
                if (str_contains($table, 'news')) {
                    $count = DB::table("$db.$table")->count();
                    echo "Table [$db.$table] has $count rows.\n";
                }
            }
        } catch (\Exception $e) {
            // No access
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
