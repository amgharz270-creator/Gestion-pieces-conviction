<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventaireLigne extends Model
{
    protected $table = 'inventaire_lignes';

    protected $fillable = [
        'inventaire_id',
        'piece_id',
        'statut',
        'emplacement_constate_id',
        'observations',
    ];

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class, 'inventaire_id');
    }

    public function piece()
    {
        return $this->belongsTo(PieceConviction::class, 'piece_id');
    }

    public function emplacementConstate()
    {
        return $this->belongsTo(Emplacement::class, 'emplacement_constate_id');
    }
}