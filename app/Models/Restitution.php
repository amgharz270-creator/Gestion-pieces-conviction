<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restitution extends Model
{
    protected $table = 'restitutions';

    protected $fillable = [
        'piece_id',
        'demandeur_nom',
        'demandeur_cin',
        'type_demandeur',
        'motif_demande',
        'jugement_reference',
        'date_jugement',
        'statut',
        'approuve_par',
        'date_approbation',
        'date_restitution',
        'receveur_nom',
        'receveur_cin',
        'receveur_signature',
        'observations',
    ];

    protected $casts = [
        'date_jugement' => 'date',
        'date_approbation' => 'datetime',
        'date_restitution' => 'datetime',
    ];

    public function piece()
    {
        return $this->belongsTo(PieceConviction::class, 'piece_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approuve_par');
    }
}