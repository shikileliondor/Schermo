<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ecoles', function (Blueprint $table) {
            $table->id();
            $table->string('nom_ecole');
            $table->string('code_ecole')->unique();
            $table->enum('type_ecole', ['primaire', 'secondaire', 'groupe']);
            $table->string('email');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('pays');
            $table->string('ville');
            $table->string('logo_path')->nullable();
            $table->string('nom_base_ecole')->unique();
            $table->enum('statut', ['brouillon', 'active', 'suspendue', 'expiree']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecoles');
    }
};
