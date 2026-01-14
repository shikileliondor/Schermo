<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $table = 'abonnements';

    protected $fillable = [
        'ecole_id',
        'plan_id',
        'date_debut',
        'date_fin',
        'statut',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
