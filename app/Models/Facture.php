<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table = 'factures';

    protected $fillable = [
        'ecole_id',
        'abonnement_id',
        'montant',
        'devise',
        'date_echeance',
        'statut',
        'chemin_pdf',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_echeance' => 'date',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
