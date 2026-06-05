<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PieceConviction;
use App\Models\Dossier;
use App\Models\Emplacement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PieceConvictionController extends Controller
{
    /**
     * Afficher la liste des pièces
     */
    
 public function index()
    {
        $user = Auth::user();
        
        // إذا كان المستخدم admin يشوف كلشي
        if ($user->hasRole('admin')) {
            $pieces = PieceConviction::with(['dossier', 'emplacement'])
                ->latest()
                ->paginate(10);
        } 
        // إذا كان responsable_argent يشوف غير argent و bijou
        elseif ($user->hasRole('responsable_argent')) {
            $pieces = PieceConviction::whereIn('categorie', ['argent', 'bijou'])
                ->with(['dossier', 'emplacement'])
                ->latest()
                ->paginate(10);
        }
        // إذا كان responsable_destruction يشوف غير drogue, arme, liquide
        elseif ($user->hasRole('responsable_destruction')) {
            $pieces = PieceConviction::whereIn('categorie', ['drogue', 'arme', 'liquide'])
                ->with(['dossier', 'emplacement'])
                ->latest()
                ->paginate(10);
        }
        // إذا كان responsable_conservation يشوف الباقي
        else {
            $pieces = PieceConviction::whereIn('categorie', ['document', 'electronique', 'objet', 'vehicule', 'autre'])
                ->with(['dossier', 'emplacement'])
                ->latest()
                ->paginate(10);
        }
        
        return view('pieces.index', compact('pieces'));
    }

    /**
     * Afficher le formulaire de création
     */
   public function create()
{
    $user = Auth::user();
    $categoriesAutorisees = $user->getCategoriesAutorisees();
    
    // Filtrer les catégories disponibles
    $toutesCategories = [
        'argent' => '💰 Argent', 'bijou' => '💎 Bijou',
        'drogue' => '💊 Drogue', 'arme' => '🔫 Arme', 'liquide' => '🧪 Liquide',
        'document' => '📄 Document', 'electronique' => '📱 Électronique',
        'objet' => '📦 Objet', 'vehicule' => '🚗 Véhicule', 'autre' => '📌 Autre',
    ];
    
    $categoriesDisponibles = array_filter($toutesCategories, function($key) use ($categoriesAutorisees) {
        return in_array($key, $categoriesAutorisees);
    }, ARRAY_FILTER_USE_KEY);
    
    $dossiers = Dossier::where('statut', 'en_cours')->get();
    $emplacements = Emplacement::where('actif', true)->get();
    
    return view('pieces.create', compact('dossiers', 'emplacements', 'categoriesDisponibles'));
}

    /**
     * Enregistrer une nouvelle pièce
     */
    public function store(Request $request)
    {
        // Validation avec messages personnalisés
        $validated = $request->validate([
            'dossier_id' => 'required|exists:dossiers,id',
            'categorie' => 'required|in:arme,document,objet,argent,drogue,vehicule,electronique,bijou,liquide,autre',
            'description' => 'required|string|min:10|max:1000',
            'quantite' => 'required|integer|min:1|max:10000',
            'etat' => 'required|in:neuf,bon,use,endommage,perissable,dangereux',
            'valeur_estimee' => 'nullable|numeric|min:0|max:10000000',
            'emplacement_id' => 'nullable|exists:emplacements,id',
            'statut' => 'required|in:saisie,depot,restituee,detruite,vendue,archivee,expertise',
            'date_saisie' => 'required|date|before_or_equal:today',
            'date_peremption' => 'nullable|date|after:date_saisie',
            'observations' => 'nullable|string|max:2000',
        ], [
            // Messages personnalisés en français
            'dossier_id.required' => 'Le dossier est obligatoire.',
            'dossier_id.exists' => 'Le dossier sélectionné n\'existe pas.',
            'categorie.in' => 'Catégorie invalide.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
            'quantite.min' => 'La quantité doit être au moins 1.',
            'quantite.max' => 'La quantité ne peut pas dépasser 10000.',
            'valeur_estimee.max' => 'La valeur estimée ne peut pas dépasser 10,000,000 DH.',
            'date_saisie.before_or_equal' => 'La date de saisie ne peut pas être dans le futur.',
            'date_peremption.after' => 'La date de péremption doit être postérieure à la date de saisie.',
            'statut.in' => 'Statut invalide.',
            'etat.in' => 'État invalide.',
        ]);

        try {
            DB::beginTransaction();

            // Vérifier la capacité de l'emplacement (si sélectionné)
            if ($request->emplacement_id) {
                $emplacement = Emplacement::find($request->emplacement_id);
                if ($emplacement && $emplacement->capacite_max && $emplacement->pieces_actuelles >= $emplacement->capacite_max) {
                    return redirect()->back()
                        ->with('error', 'Emplacement complet ! Capacité maximale atteinte.')
                        ->withInput();
                }
            }

            // Générer référence unique avec vérification anti-doublon
            $year = now()->year;
            $reference = $this->generateUniqueReference($year);
            
            // Générer QR code unique
            $qrCode = $this->generateUniqueQrCode($year);

            $piece = PieceConviction::create([
                ...$validated,
                'reference' => $reference,
                'qr_code' => $qrCode,
                'created_by' => auth()->id(), // Ajouter l'utilisateur qui a créé
            ]);

            // Mettre à jour le compteur d'emplacement
            if ($piece->emplacement_id) {
                Emplacement::find($piece->emplacement_id)->increment('pieces_actuelles');
            }

            DB::commit();

            return redirect()->route('pieces.index')
                ->with('success', 'Pièce ' . $reference . ' créée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Afficher une pièce
     */
    public function show(PieceConviction $piece)
    {
        $piece->load(['dossier', 'emplacement', 'mouvements.user', 'restitutions']);
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
            'description' => 'required|string|min:10|max:1000',
            'quantite' => 'required|integer|min:1|max:10000',
            'etat' => 'required|in:neuf,bon,use,endommage,perissable,dangereux',
            'valeur_estimee' => 'nullable|numeric|min:0|max:10000000',
            'emplacement_id' => 'nullable|exists:emplacements,id',
            'statut' => 'required|in:saisie,depot,restituee,detruite,vendue,archivee,expertise',
            'date_saisie' => 'required|date|before_or_equal:today',
            'date_peremption' => 'nullable|date|after:date_saisie',
            'observations' => 'nullable|string|max:2000',
        ], [
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'quantite.max' => 'La quantité ne peut pas dépasser 10000.',
            'date_saisie.before_or_equal' => 'La date de saisie ne peut pas être dans le futur.',
            'date_peremption.after' => 'La date de péremption doit être postérieure à la date de saisie.',
        ]);

        try {
            DB::beginTransaction();

            $oldEmplacementId = $piece->emplacement_id;

            // Vérifier la capacité du nouvel emplacement
            if ($request->emplacement_id && $request->emplacement_id != $oldEmplacementId) {
                $newEmplacement = Emplacement::find($request->emplacement_id);
                if ($newEmplacement && $newEmplacement->capacite_max && $newEmplacement->pieces_actuelles >= $newEmplacement->capacite_max) {
                    return redirect()->back()
                        ->with('error', 'Emplacement complet ! Capacité maximale atteinte.')
                        ->withInput();
                }
            }

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

            DB::commit();

            return redirect()->route('pieces.index')
                ->with('success', 'Pièce ' . $piece->reference . ' mise à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprimer une pièce (Soft Delete)
     */
    public function destroy(PieceConviction $piece)
    {
        try {
            DB::beginTransaction();

            $reference = $piece->reference;

            // Mettre à jour le compteur d'emplacement
            if ($piece->emplacement_id) {
                Emplacement::find($piece->emplacement_id)->decrement('pieces_actuelles');
            }

            // Soft delete (si SoftDeletes est activé dans le modèle)
            $piece->delete();

            DB::commit();

            return redirect()->route('pieces.index')
                ->with('success', 'Pièce ' . $reference . ' supprimée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Restaurer une pièce supprimée (Soft Delete)
     */
    public function restore($id)
    {
        try {
            DB::beginTransaction();

            $piece = PieceConviction::withTrashed()->findOrFail($id);
            $piece->restore();

            // Restaurer le compteur d'emplacement
            if ($piece->emplacement_id) {
                Emplacement::find($piece->emplacement_id)->increment('pieces_actuelles');
            }

            DB::commit();

            return redirect()->route('pieces.index')
                ->with('success', 'Pièce ' . $piece->reference . ' restaurée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la restauration: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer définitivement une pièce (Force Delete)
     */
    public function forceDelete($id)
    {
        try {
            DB::beginTransaction();

            $piece = PieceConviction::withTrashed()->findOrFail($id);
            $reference = $piece->reference;

            // Mettre à jour le compteur d'emplacement si nécessaire
            if ($piece->emplacement_id && !$piece->trashed()) {
                Emplacement::find($piece->emplacement_id)->decrement('pieces_actuelles');
            }

            $piece->forceDelete();

            DB::commit();

            return redirect()->route('pieces.index')
                ->with('success', 'Pièce ' . $reference . ' supprimée définitivement !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression définitive: ' . $e->getMessage());
        }
    }

    /**
     * Générer une référence unique
     */
    private function generateUniqueReference($year)
    {
        $attempts = 0;
        $maxAttempts = 10;
        
        do {
            $lastPiece = PieceConviction::whereYear('created_at', $year)
                ->orderBy('id', 'desc')
                ->first();
            
            $num = $lastPiece ? intval(substr($lastPiece->reference, -4)) + 1 : 1;
            $reference = 'PC-' . $year . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
            
            $attempts++;
            
            if ($attempts >= $maxAttempts) {
                // Fallback: utiliser timestamp
                $reference = 'PC-' . $year . '-' . time();
                break;
            }
            
        } while (PieceConviction::where('reference', $reference)->exists());
        
        return $reference;
    }

    /**
     * Générer un QR code unique
     */
    private function generateUniqueQrCode($year)
    {
        do {
            $qrCode = 'QR-' . $year . '-' . strtoupper(Str::random(8));
        } while (PieceConviction::where('qr_code', $qrCode)->exists());
        
        return $qrCode;
    }

    /**
     * Exporter les pièces en PDF/Excel
     */
    public function export(Request $request)
    {
        $pieces = PieceConviction::with(['dossier', 'emplacement'])
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->when($request->categorie, fn($q) => $q->where('categorie', $request->categorie))
            ->get();
        
        // Logique d'export à implémenter selon ton besoin
        // return Excel::download(new PiecesExport($pieces), 'pieces.xlsx');
        
        return redirect()->back()->with('info', 'Fonctionnalité d\'export en cours de développement.');
    }
}