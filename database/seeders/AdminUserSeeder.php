<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::where('email', 'admin@admin.com')->first();

        if (!$adminUser) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}
