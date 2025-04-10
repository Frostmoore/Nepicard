<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change(); // nel caso fosse NOT NULL
            $table->string('surname')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->integer('points')->nullable()->after('phone');
            $table->string('address')->nullable()->after('points');
            $table->string('category')->nullable()->after('address');
            $table->string('website')->nullable()->after('category');
            $table->string('status')->nullable()->after('website');
            $table->string('description')->nullable()->after('status');
            $table->string('coordinates')->nullable()->after('description');
            $table->string('ditta')->nullable()->after('coordinates');
            $table->string('sede')->nullable()->after('ditta');
            $table->string('piva')->nullable()->after('sede');
            $table->string('cf')->nullable()->after('piva');
            $table->string('pec')->nullable()->after('cf');
            $table->string('codice_univoco')->nullable()->after('pec');
            $table->string('role')->nullable()->after('codice_univoco');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'surname',
                'phone',
                'points',
                'address',
                'category',
                'website',
                'status',
                'description',
                'coordinates',
                'ditta',
                'sede',
                'piva',
                'cf',
                'pec',
                'codice_univoco',
                'role',
            ]);
        });
    }
};
