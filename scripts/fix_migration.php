<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Delete the old record
    DB::table('migrations')->where('migration', '2024_01_08_create_contact_messages_table')->delete();
    // Insert the new record so Laravel thinks it's already done (since the table exists)
    DB::table('migrations')->insert([
        'migration' => '2025_08_01_150738_create_contact_messages_table',
        'batch' => 1
    ]);
    echo "Migration record updated successfully.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
