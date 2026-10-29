<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
$databases = DB::select('SHOW DATABASES');
$list = array_map(fn($d) => array_values((array)$d)[0], $databases);
file_put_contents('all_dbs_list.txt', implode("\n", $list));
echo "Saved " . count($list) . " databases to all_dbs_list.txt\n";
