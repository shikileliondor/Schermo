<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilisateurPlateforme extends Model
{
    use HasFactory;

    protected $table = 'utilisateurs_plateforme';

    protected $fillable = [
        'nom',
        'prenoms',
        'email',
        'mot_de_passe',
        'role',
        'statut',
    ];
}
