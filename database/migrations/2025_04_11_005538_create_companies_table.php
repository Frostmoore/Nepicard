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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('website')->nullable();
            $table->string('category')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('points')->default(0);
            $table->string('piva')->nullable();
            $table->string('cf')->nullable();
            $table->string('pec')->nullable();
            $table->string('codice_univoco')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
