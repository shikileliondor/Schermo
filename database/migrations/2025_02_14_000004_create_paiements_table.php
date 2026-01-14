<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facture_id')
                ->constrained('factures')
                ->restrictOnDelete();
            $table->decimal('montant', 12, 2);
            $table->enum('mode_paiement', ['especes', 'mobile_money', 'banque']);
            $table->string('reference_paiement');
            $table->date('date_paiement');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
