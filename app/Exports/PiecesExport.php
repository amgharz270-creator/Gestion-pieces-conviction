<?php

namespace App\Exports;

use App\Models\PieceConviction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PiecesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $pieces;

    public function __construct($pieces = null)
    {
        $this->pieces = $pieces;
    }

    public function collection()
    {
        return $this->pieces ?: PieceConviction::with(['dossier', 'emplacement'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Référence',
            'QR Code',
            'Description',
            'Catégorie',
            'Quantité',
            'État',
            'Valeur Estimée (DH)',
            'Statut',
            'Dossier',
            'Emplacement',
            'Date de saisie',
            'Date de péremption',
            'Observations',
            'Créé le',
        ];
    }

    public function map($piece): array
    {
        return [
            $piece->id,
            $piece->reference,
            $piece->qr_code,
            $piece->description,
            $piece->categorie,
            $piece->quantite,
            $piece->etat,
            $piece->valeur_estimee,
            $piece->statut,
            $piece->dossier->numero_dossier ?? 'N/A',
            $piece->emplacement ? $piece->emplacement->salle . ' - ' . $piece->emplacement->armoire : 'N/A',
            $piece->date_saisie?->format('d/m/Y'),
            $piece->date_peremption?->format('d/m/Y'),
            $piece->observations,
            $piece->created_at?->format('d/m/Y H:i'),
        ];
    }
}