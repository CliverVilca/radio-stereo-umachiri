<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $databases = DB::select('SHOW DATABASES');
    $list = array_map(fn($d) => array_values((array)$d)[0], $databases);
    
    echo "Total databases: " . count($list) . "\n";
    if (in_array('dbstereo', $list)) echo "Found: dbstereo\n";
    if (in_array('DBStereo', $list)) echo "Found: DBStereo\n";
    
    // Print all to be sure
    foreach ($list as $db) {
        echo "$db\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
