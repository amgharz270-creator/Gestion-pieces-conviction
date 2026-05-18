<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PieceConviction;
use App\Models\Dossier;
use App\Models\Emplacement;
use Illuminate\Support\Str;

class PieceConvictionController extends Controller
{
    /**
     * Afficher la liste des pièces
     */
    public function index()
    {
        $pieces = PieceConviction::with(['dossier', 'emplacement'])
            ->latest()
            ->paginate(10);

        return view('pieces.index', compact('pieces'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $dossiers = Dossier::where('statut', 'en_cours')->get();
        $emplacements = Emplacement::where('actif', true)->get();

        return view('pieces.create', compact('dossiers', 'emplacements'));
    }

    /**
     * Enregistrer une nouvelle pièce
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dossier_id' => 'required|exists:dossiers,id',
            'categorie' => 'required|in:arme,document,objet,argent,drogue,vehicule,electronique,bijou,liquide,autre',
            'description' => 'required|string|max:1000',
            'quantite' => 'required|integer|min:1',
            'etat' => 'required|in:neuf,bon,use,endommage,perissable,dangereux',
            'valeur_estimee' => 'nullable|numeric|min:0',
            'emplacement_id' => 'nullable|exists:emplacements,id',
            'statut' => 'required|in:saisie,depot,restituee,detruite,vendue,archivee,expertise',
            'date_saisie' => 'required|date',
            'date_peremption' => 'nullable|date|after_or_equal:date_saisie',
            'observations' => 'nullable|string|max:2000',
        ]);

        // Générer référence unique
        $year = now()->year;
        $lastPiece = PieceConviction::whereYear('created_at', $year)->latest()->first();
        $num = $lastPiece ? intval(substr($lastPiece->reference, -4)) + 1 : 1;
        $reference = 'PC-' . $year . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);

        // Générer QR code
        $qrCode = 'QR-' . $year . '-' . strtoupper(Str::random(8));

        $piece = PieceConviction::create([
            ...$validated,
            'reference' => $reference,
            'qr_code' => $qrCode,
        ]);

        // Mettre à jour le compteur d'emplacement
        if ($piece->emplacement_id) {
            $emplacement = Emplacement::find($piece->emplacement_id);
            $emplacement->increment('pieces_actuelles');
        }

        return redirect()->route('pieces.index')
            ->with('success', 'Pièce ' . $reference . ' créée avec succès !');
    }

    /**
     * Afficher une pièce
     */
    public function show(PieceConviction $piece)
    {
        $piece->load(['dossier', 'emplacement', 'mouvements', 'restitutions']);
        return view('pieces.show', compact('piece'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(PieceConviction $piece)
    {
        $dossiers = Dossier::where('statut', 'en_cours')->get();
        $emplacements = Emplacement::where('actif', true)->get();

        return view('pieces.edit', compact('piece', 'dossiers', 'emplacements'));
    }

    /**
     * Mettre à jour une pièce
     */
    public function update(Request $request, PieceConviction $piece)
    {
        $validated = $request->validate([
            'dossier_id' => 'required|exists:dossiers,id',
            'categorie' => 'required|in:arme,document,objet,argent,drogue,vehicule,electronique,bijou,liquide,autre',
            'description' => 'required|string|max:1000',
            'quantite' => 'required|integer|min:1',
            'etat' => 'required|in:neuf,bon,use,endommage,perissable,dangereux',
            'valeur_estimee' => 'nullable|numeric|min:0',
            'emplacement_id' => 'nullable|exists:emplacements,id',
            'statut' => 'required|in:saisie,depot,restituee,detruite,vendue,archivee,expertise',
            'date_saisie' => 'required|date',
            'date_peremption' => 'nullable|date|after_or_equal:date_saisie',
            'observations' => 'nullable|string|max:2000',
        ]);

        $oldEmplacementId = $piece->emplacement_id;

        $piece->update($validated);

        // Mettre à jour les compteurs d'emplacement
        if ($oldEmplacementId != $piece->emplacement_id) {
            if ($oldEmplacementId) {
                Emplacement::find($oldEmplacementId)->decrement('pieces_actuelles');
            }
            if ($piece->emplacement_id) {
                Emplacement::find($piece->emplacement_id)->increment('pieces_actuelles');
            }
        }

        return redirect()->route('pieces.index')
            ->with('success', 'Pièce ' . $piece->reference . ' mise à jour avec succès !');
    }

    /**
     * Supprimer une pièce
     */
    public function destroy(PieceConviction $piece)
    {
        $reference = $piece->reference;

        // Mettre à jour le compteur d'emplacement
        if ($piece->emplacement_id) {
            Emplacement::find($piece->emplacement_id)->decrement('pieces_actuelles');
        }

        $piece->delete();

        return redirect()->route('pieces.index')
            ->with('success', 'Pièce ' . $reference . ' supprimée avec succès !');
    }
}