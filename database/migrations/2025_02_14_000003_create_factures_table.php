<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ecole_id')
                ->constrained('ecoles')
                ->restrictOnDelete();
            $table->foreignId('abonnement_id')
                ->constrained('abonnements')
                ->restrictOnDelete();
            $table->decimal('montant', 12, 2);
            $table->string('devise', 10);
            $table->date('date_echeance');
            $table->enum('statut', ['payee', 'impayee', 'en_retard']);
            $table->string('chemin_pdf')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
