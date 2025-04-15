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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('start');
            $table->string('end');
            $table->string('points');
            $table->string('picture');
            $table->string('company');
            $table->string('short_description');
            $table->string('url');
            $table->string('type');
            $table->string('status');
            $table->string('category');
            $table->string('address');
            $table->string('coordinates');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
