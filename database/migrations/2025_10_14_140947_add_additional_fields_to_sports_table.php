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
        Schema::table('sports', function (Blueprint $table) {
            $table->string('category')->default('otros')->after('author');
            $table->enum('status', ['draft', 'published'])->default('published')->after('published_at');
            $table->boolean('is_featured')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sports', function (Blueprint $table) {
            $table->dropColumn(['category', 'status', 'is_featured']);
        });
    }
};
