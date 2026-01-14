<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateurs_plateforme', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('email');
            $table->string('mot_de_passe');
            $table->enum('role', ['super_admin', 'support', 'commercial']);
            $table->enum('statut', ['actif', 'inactif']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs_plateforme');
    }
};
