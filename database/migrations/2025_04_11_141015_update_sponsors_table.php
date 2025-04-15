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
        Schema::table('sponsors', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('points')->nullable()->change();
            $table->string('picture')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('category')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('coordinates')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->string('points')->nullable(false)->change();
            $table->string('picture')->nullable(false)->change();
            $table->string('url')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
            $table->string('category')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('coordinates')->nullable(false)->change();
        });
    }
};
