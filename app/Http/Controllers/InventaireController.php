<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaire;
use App\Models\InventaireLigne;
use App\Models\PieceConviction;
use App\Models\Emplacement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventaireController extends Controller
{
    /**
     * Afficher la liste des inventaires
     */
    public function index(Request $request)
    {
        $query = Inventaire::with(['realisePar', 'verifiePar'])
            ->withCount('lignes');
        
        // Filtrer par statut si spécifié
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        // Filtrer par type si spécifié
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $inventaires = $query->latest()->paginate(10);
        
        return view('inventaires.index', compact('inventaires'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $pieces = PieceConviction::with('emplacement')->get();
        $users = User::whereIn('role', ['admin', 'magasinier'])->get();
        return view('inventaires.create', compact('pieces', 'users'));
    }

    /**
     * Enregistrer un nouvel inventaire
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:complet,partiel,surprise',
            'date_planifiee' => 'required|date|after_or_equal:today',
            'verifie_par' => 'nullable|exists:users,id|different:realise_par',
            'observations' => 'nullable|string|max:2000',
        ]);

        $year = now()->year;
        $lastInv = Inventaire::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $num = $lastInv ? intval(substr($lastInv->reference, -3)) + 1 : 1;
        $reference = 'INV-' . $year . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);

        // Vérifier unicité
        while (Inventaire::where('reference', $reference)->exists()) {
            $num++;
            $reference = 'INV-' . $year . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        }

        // Récupérer toutes les pièces avec leurs relations
        $pieces = PieceConviction::with('emplacement')->get();

        try {
            DB::beginTransaction();

            $inventaire = Inventaire::create([
                'reference' => $reference,
                'realise_par' => Auth::id(),
                'verifie_par' => $validated['verifie_par'] ?? null,
                'type' => $validated['type'],
                'statut' => 'planifie',
                'date_planifiee' => $validated['date_planifiee'],
                'pieces_attendues' => $pieces->count(),
                'observations' => $validated['observations'] ?? null,
            ]);

            // Créer les lignes d'inventaire pour chaque pièce
            foreach ($pieces as $piece) {
                InventaireLigne::create([
                    'inventaire_id' => $inventaire->id,
                    'piece_id' => $piece->id,
                    'statut' => 'presente',
                    'emplacement_constate_id' => $piece->emplacement_id,
                ]);
            }

            DB::commit();

            return redirect()->route('inventaires.index')
                ->with('success', 'Inventaire ' . $reference . ' créé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Afficher un inventaire
     */
    public function show(Inventaire $inventaire)
    {
        $inventaire->load(['realisePar', 'verifiePar', 'lignes.piece', 'lignes.emplacementConstate']);
        
        // Calculer les statistiques
        $stats = [
            'total' => $inventaire->lignes->count(),
            'presentes' => $inventaire->lignes->where('statut', 'presente')->count(),
            'manquantes' => $inventaire->lignes->where('statut', 'manquante')->count(),
            'endommagees' => $inventaire->lignes->where('statut', 'endommagee')->count(),
            'deplacees' => $inventaire->lignes->where('statut', 'deplacee')->count(),
        ];
        
        return view('inventaires.show', compact('inventaire', 'stats'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Inventaire $inventaire)
    {
        if ($inventaire->statut == 'termine' || $inventaire->statut == 'anomalie') {
            return back()->with('error', 'Impossible de modifier un inventaire terminé');
        }
        
        $users = User::whereIn('role', ['admin', 'magasinier'])->get();
        $inventaire->load('lignes.piece', 'lignes.emplacementConstate');
        
        return view('inventaires.edit', compact('inventaire', 'users'));
    }

    /**
     * Mettre à jour un inventaire
     */
    public function update(Request $request, Inventaire $inventaire)
    {
        if ($inventaire->statut == 'termine' || $inventaire->statut == 'anomalie') {
            return back()->with('error', 'Impossible de modifier un inventaire terminé');
        }

        $validated = $request->validate([
            'type' => 'required|in:complet,partiel,surprise',
            'date_planifiee' => 'required|date|after_or_equal:today',
            'verifie_par' => 'nullable|exists:users,id',
            'observations' => 'nullable|string|max:2000',
        ]);

        $inventaire->update($validated);

        return redirect()->route('inventaires.index')
            ->with('success', 'Inventaire mis à jour');
    }

    /**
     * Supprimer un inventaire
     */
    public function destroy(Inventaire $inventaire)
    {
        // Vérifier si l'inventaire n'est pas en cours
        if ($inventaire->statut == 'en_cours') {
            return back()->with('error', 'Impossible de supprimer un inventaire en cours');
        }

        try {
            DB::beginTransaction();
            $inventaire->lignes()->delete();
            $inventaire->delete();
            DB::commit();
            
            return redirect()->route('inventaires.index')
                ->with('success', 'Inventaire supprimé');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Démarrer l'inventaire
     */
    public function demarrer(Inventaire $inventaire)
    {
        if ($inventaire->statut != 'planifie') {
            return back()->with('error', 'L\'inventaire ne peut pas être démarré');
        }

        $inventaire->update([
            'statut' => 'en_cours',
            'date_debut' => now(),
        ]);

        return redirect()->route('inventaires.edit', $inventaire)
            ->with('success', 'Inventaire démarré. Vous pouvez maintenant enregistrer les constatations.');
    }

    /**
     * Terminer l'inventaire
     */
    public function terminer(Request $request, Inventaire $inventaire)
    {
        if ($inventaire->statut != 'en_cours') {
            return back()->with('error', 'L\'inventaire doit être en cours');
        }

        $validated = $request->validate([
            'observations' => 'nullable|string|max:2000',
        ]);

        $piecesTrouvees = $inventaire->lignes()->where('statut', 'presente')->count();
        $piecesManquantes = $inventaire->lignes()->where('statut', 'manquante')->count();
        $piecesEndommagees = $inventaire->lignes()->where('statut', 'endommagee')->count();
        $piecesDeplacees = $inventaire->lignes()->where('statut', 'deplacee')->count();
        
        $totalAnomalies = $piecesManquantes + $piecesEndommagees + $piecesDeplacees;

        $inventaire->update([
            'statut' => ($totalAnomalies > 0) ? 'anomalie' : 'termine',
            'date_fin' => now(),
            'pieces_trouvees' => $piecesTrouvees,
            'pieces_manquantes' => $totalAnomalies,
            'observations' => $validated['observations'] ?? $inventaire->observations,
        ]);

        $message = $totalAnomalies > 0 
            ? 'Inventaire terminé avec ' . $totalAnomalies . ' anomalie(s) détectée(s)'
            : 'Inventaire terminé avec succès, aucune anomalie';

        return redirect()->route('inventaires.show', $inventaire)
            ->with('success', $message);
    }

    /**
     * Mettre à jour le statut d'une ligne d'inventaire
     */
    public function updateLigne(Request $request, InventaireLigne $ligne)
    {
        $inventaire = $ligne->inventaire;
        
        // Vérifier que l'inventaire est en cours
        if ($inventaire->statut != 'en_cours') {
            return back()->with('error', 'L\'inventaire doit être en cours pour modifier les lignes');
        }

        $validated = $request->validate([
            'statut' => 'required|in:presente,manquante,endommagee,deplacee',
            'emplacement_constate_id' => 'nullable|exists:emplacements,id',
            'observations' => 'nullable|string|max:2000',
        ]);

        $ligne->update($validated);

        return back()->with('success', 'Ligne mise à jour');
    }

    /**
     * Afficher les anomalies
     */
    public function anomalies()
    {
        $anomalies = Inventaire::where('statut', 'anomalie')
            ->with(['realisePar', 'verifiePar', 'lignes' => function($query) {
                $query->where('statut', '!=', 'presente')
                      ->with('piece', 'emplacementConstate');
            }])
            ->latest()
            ->paginate(10);
        
        return view('inventaires.anomalies', compact('anomalies'));
    }

    /**
     * Exporter l'inventaire en CSV
     */
    public function export(Inventaire $inventaire)
    {
        $inventaire->load(['lignes.piece', 'lignes.emplacementConstate']);
        
        $filename = 'inventaire_' . $inventaire->reference . '_' . date('Y-m-d') . '.csv';
        
        $handle = fopen('php://output', 'w');
        
        // En-têtes CSV
        fputcsv($handle, [
            'Référence Pièce',
            'Description',
            'Catégorie',
            'Emplacement Système',
            'Emplacement Constaté',
            'Statut',
            'Observations'
        ]);
        
        // Données
        foreach ($inventaire->lignes as $ligne) {
            fputcsv($handle, [
                $ligne->piece->reference,
                $ligne->piece->description,
                $ligne->piece->categorie,
                $ligne->piece->emplacement->salle . ' - ' . ($ligne->piece->emplacement->armoire ?? 'N/A'),
                $ligne->emplacementConstate ? $ligne->emplacementConstate->salle . ' - ' . ($ligne->emplacementConstate->armoire ?? 'N/A') : 'Non constaté',
                $ligne->statut,
                $ligne->observations ?? ''
            ]);
        }
        
        fclose($handle);
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        exit;
    }

    /**
     * Statistiques des inventaires
     */
    public function statistiques()
    {
        $stats = [
            'total' => Inventaire::count(),
            'planifies' => Inventaire::where('statut', 'planifie')->count(),
            'en_cours' => Inventaire::where('statut', 'en_cours')->count(),
            'termines' => Inventaire::where('statut', 'termine')->count(),
            'anomalies' => Inventaire::where('statut', 'anomalie')->count(),
            'total_pieces_inventoriees' => InventaireLigne::count(),
            'total_anomalies_detectees' => InventaireLigne::where('statut', '!=', 'presente')->count(),
        ];
        
        // Statistiques par mois
        $statsParMois = Inventaire::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN statut = "termine" THEN 1 ELSE 0 END) as termines'),
            DB::raw('SUM(CASE WHEN statut = "anomalie" THEN 1 ELSE 0 END) as anomalies')
        )
        ->groupBy('mois')
        ->orderBy('mois', 'desc')
        ->limit(12)
        ->get();
        
        return view('inventaires.statistiques', compact('stats', 'statsParMois'));
    }
}