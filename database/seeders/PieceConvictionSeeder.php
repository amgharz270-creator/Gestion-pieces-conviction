<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PieceConviction;
use App\Models\Dossier;
use App\Models\Emplacement;

class PieceConvictionSeeder extends Seeder
{
    public function run()
    {
        $dossier = Dossier::first();
        if (!$dossier) {
            $dossier = Dossier::create([
                'numero_dossier' => '2026/001',
                'parties' => 'État vs Prévenu',
                'type_affaire' => 'pénal',
                'statut' => 'en_cours'
            ]);
        }

        $emplacement = Emplacement::first();
        if (!$emplacement) {
            $emplacement = Emplacement::create([
                'salle' => 'Salle Principale',
                'armoire' => 'Armoire A1',
                'etagere' => 'Etagère 1',
                'actif' => true
            ]);
        }

        $categories = ['argent', 'drogue', 'arme', 'document', 'electronique', 'bijou', 'vehicule'];
        
        for ($i = 1; $i <= 10; $i++) {
            $categorie = $categories[array_rand($categories)];
            PieceConviction::create([
                'reference' => 'PC-2026-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'qr_code' => 'QR-' . $i . '-' . substr(md5(uniqid()), 0, 8),
                'dossier_id' => $dossier->id,
                'categorie' => $categorie,
                'description' => 'Pièce à conviction de test n°' . $i . ' - Catégorie: ' . $categorie,
                'quantite' => rand(1, 5),
                'etat' => ['neuf', 'bon', 'use'][array_rand(['neuf', 'bon', 'use'])],
                'valeur_estimee' => rand(100, 50000),
                'emplacement_id' => $emplacement->id,
                'statut' => 'saisie',
                'date_saisie' => now(),
                'observations' => 'Pièce créée automatiquement par seeder',
            ]);
        }
    }
}