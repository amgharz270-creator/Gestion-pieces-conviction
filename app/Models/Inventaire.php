<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    protected $table = 'inventaires';

    protected $fillable = [
        'reference',
        'realise_par',
        'verifie_par',
        'type',
        'statut',
        'date_planifiee',
        'date_debut',
        'date_fin',
        'pieces_attendues',
        'pieces_trouvees',
        'pieces_manquantes',
        'observations',
    ];

    protected $casts = [
        'date_planifiee' => 'date',
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    public function realisePar()
    {
        return $this->belongsTo(User::class, 'realise_par');
    }

    public function verifiePar()
    {
        return $this->belongsTo(User::class, 'verifie_par');
    }

    public function lignes()
    {
        return $this->hasMany(InventaireLigne::class, 'inventaire_id');
    }
}