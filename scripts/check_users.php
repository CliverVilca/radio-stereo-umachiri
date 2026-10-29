<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $users = DB::table('users')->get();
    echo "Users in database:\n";
    foreach ($users as $user) {
        echo "- " . $user->email . " (Created at: " . $user->created_at . ")\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
