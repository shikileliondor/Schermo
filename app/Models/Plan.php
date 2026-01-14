<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $fillable = [
        'nom_plan',
        'max_eleves',
        'modules',
        'prix',
        'duree_mois',
    ];

    protected $casts = [
        'modules' => 'array',
        'prix' => 'decimal:2',
    ];

    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }
}
