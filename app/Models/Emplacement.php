<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emplacement extends Model
{
    protected $table = 'emplacements';

    protected $fillable = [
        'salle',
        'armoire',
        'etagere',
        'boite',
        'capacite_max',
        'pieces_actuelles',
        'notes',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'capacite_max' => 'integer',
        'pieces_actuelles' => 'integer',
    ];

    // ⭐ RELATION CORRIGÉE
    public function pieces()
    {
        return $this->hasMany(PieceConviction::class, 'emplacement_id');
    }

    public function mouvementsFrom()
    {
        return $this->hasMany(Mouvement::class, 'from_emplacement_id');
    }

    public function mouvementsTo()
    {
        return $this->hasMany(Mouvement::class, 'to_emplacement_id');
    }
}