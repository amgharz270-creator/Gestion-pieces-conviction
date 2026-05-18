<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model
{
    protected $table = 'mouvements';

    protected $fillable = [
        'piece_id',
        'from_user_id',
        'to_user_id',
        'from_emplacement_id',
        'to_emplacement_id',
        'type',
        'motif',
        'document_reference',
        'date_mouvement',
        'date_retour_prevue',
        'date_retour_effective',
        'observations',
    ];

    protected $casts = [
        'date_mouvement' => 'datetime',
        'date_retour_prevue' => 'datetime',
        'date_retour_effective' => 'datetime',
    ];

    public function piece()
    {
        return $this->belongsTo(PieceConviction::class, 'piece_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function fromEmplacement()
    {
        return $this->belongsTo(Emplacement::class, 'from_emplacement_id');
    }

    public function toEmplacement()
    {
        return $this->belongsTo(Emplacement::class, 'to_emplacement_id');
    }
}