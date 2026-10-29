<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('djs', function (Blueprint $table) {
            $table->string('specialty')->nullable()->after('name');
            $table->string('email')->nullable()->after('bio');
            $table->string('phone')->nullable()->after('email');
            $table->string('image')->nullable()->after('phone');
            $table->string('photo_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('djs', function (Blueprint $table) {
            $table->dropColumn(['specialty', 'email', 'phone', 'image']);
        });
    }
};
