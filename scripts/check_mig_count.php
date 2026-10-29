<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $count = DB::table('migrations')->count();
    echo "Total migrations in database: $count\n";
    
    $last = DB::table('migrations')->latest('id')->first();
    echo "Last migration: " . ($last ? $last->migration : 'None') . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
