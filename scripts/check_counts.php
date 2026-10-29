<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$tables = ['events', 'news', 'programs', 'sports', 'djs', 'galleries', 'users'];

echo "Row counts for connected database:\n";
foreach ($tables as $table) {
    try {
        if (Schema::hasTable($table)) {
            $count = DB::table($table)->count();
            echo "- $table: $count\n";
        } else {
            echo "- $table: TABLE NOT FOUND\n";
        }
    } catch (\Exception $e) {
        echo "- $table: ERROR (" . $e->getMessage() . ")\n";
    }
}
