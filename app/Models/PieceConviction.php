<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieceConviction extends Model
{
    protected $table = 'pieces_conviction';  // ← AJOUTER HADI
    
    protected $fillable = [
        'dossier_id', 'reference', 'categorie', 'description',
        'quantite', 'etat', 'valeur_estimee', 'photos', 'qr_code',
        'emplacement_id', 'statut', 'date_saisie', 'date_peremption', 'observations',
    ];
    
    protected $casts = [
        'photos' => 'array',
        'date_saisie' => 'date',
        'date_peremption' => 'date',
        'valeur_estimee' => 'decimal:2',
    ];
    
    // Relations
    public function dossier() { return $this->belongsTo(Dossier::class); }
    public function emplacement() { return $this->belongsTo(Emplacement::class); }
    public function mouvements() { return $this->hasMany(Mouvement::class, 'piece_id'); }
    public function restitutions() { return $this->hasMany(Restitution::class, 'piece_id'); }
}