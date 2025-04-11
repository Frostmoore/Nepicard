<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('website');
            $table->dropColumn('description');
            $table->dropColumn('coordinates');
            $table->dropColumn('ditta');
            $table->dropColumn('sede');
            $table->dropColumn('piva');
            $table->dropColumn('cf');
            $table->dropColumn('pec');
            $table->dropColumn('codice_univoco');
            $table->string('company')->nullable()->after('role'); // nel caso fosse NOT NULL
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->string('website')->nullable();
            $table->string('description')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('ditta')->nullable();
            $table->string('sede')->nullable();
            $table->string('piva')->nullable();
            $table->string('cf')->nullable();
            $table->string('pec')->nullable();
            $table->string('codice_univoco')->nullable();
            $table->dropColumn('company')->nullable();
        });
    }
};
