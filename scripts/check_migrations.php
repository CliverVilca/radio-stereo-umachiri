<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $migrations = DB::table('migrations')->get();
    echo "Migrations recorded:\n";
    foreach ($migrations as $migration) {
        echo "- " . $migration->migration . " (Batch: " . $migration->batch . ")\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
