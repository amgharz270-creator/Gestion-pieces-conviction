<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $table = 'dossiers';

    protected $fillable = [
        'numero_dossier',
        'type_affaire',
        'parties',
        'juge_id',
        'statut',
        'date_ouverture',
        'date_cloture',
        'observations',
    ];

    protected $casts = [
        'date_ouverture' => 'date',
        'date_cloture' => 'date',
    ];

    public function juge()
    {
        return $this->belongsTo(User::class, 'juge_id');
    }

    public function pieces()
    {
        return $this->hasMany(PieceConviction::class);
    }
}