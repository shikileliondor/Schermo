<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;

    protected $table = 'ecoles';

    protected $fillable = [
        'nom_ecole',
        'code_ecole',
        'type_ecole',
        'email',
        'telephone',
        'adresse',
        'pays',
        'ville',
        'logo_path',
        'nom_base_ecole',
        'statut',
    ];

    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
