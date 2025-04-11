<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('address')->nullable();
            $table->integer('available_points')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('events');
    }
};
