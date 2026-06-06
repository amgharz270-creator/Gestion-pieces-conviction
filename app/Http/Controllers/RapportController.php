<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PieceConviction;
use App\Models\Dossier;
use App\Models\Restitution;
use App\Models\Inventaire;
use App\Models\Mouvement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RapportController extends Controller
{
    // حذف __construct() تماماً

    public function index()
    {
        // Vérification manuelle
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Seul l\'administrateur peut accéder aux rapports.');
        }

        // Statistiques globales
        $stats = [
            'total_pieces' => PieceConviction::count(),
            'pieces_par_categorie' => PieceConviction::select('categorie', DB::raw('count(*) as total'))
                ->groupBy('categorie')
                ->get(),
            'pieces_par_statut' => PieceConviction::select('statut', DB::raw('count(*) as total'))
                ->groupBy('statut')
                ->get(),
            'total_dossiers' => Dossier::count(),
            'dossiers_par_statut' => Dossier::select('statut', DB::raw('count(*) as total'))
                ->groupBy('statut')
                ->get(),
            'restitutions_par_statut' => Restitution::select('statut', DB::raw('count(*) as total'))
                ->groupBy('statut')
                ->get(),
            'inventaires_par_mois' => Inventaire::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
                    DB::raw('count(*) as total')
                )
                ->groupBy('mois')
                ->orderBy('mois', 'desc')
                ->limit(6)
                ->get(),
            'pieces_par_mois' => PieceConviction::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
                    DB::raw('count(*) as total')
                )
                ->groupBy('mois')
                ->orderBy('mois', 'desc')
                ->limit(6)
                ->get(),
            'top_emplacements' => PieceConviction::select('emplacement_id', DB::raw('count(*) as total'))
                ->whereNotNull('emplacement_id')
                ->groupBy('emplacement_id')
                ->with('emplacement')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),
            'utilisateurs_actifs' => User::where('actif', true)->count(),
            'taux_occupation' => $this->calculerTauxOccupation(),
        ];

        return view('rapports.index', compact('stats'));
    }

    public function pieces(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $query = PieceConviction::with(['dossier', 'emplacement']);

        if ($request->categorie) {
            $query->where('categorie', $request->categorie);
        }
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }
        if ($request->date_debut) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->date_fin) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $pieces = $query->latest()->paginate(20);
        
        $categories = PieceConviction::select('categorie')->distinct()->pluck('categorie');
        $statuts = PieceConviction::select('statut')->distinct()->pluck('statut');
        
        return view('rapports.pieces', compact('pieces', 'categories', 'statuts'));
    }

    public function dossiers(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $query = Dossier::with(['pieces']);

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }
        if ($request->type_affaire) {
            $query->where('type_affaire', $request->type_affaire);
        }

        $dossiers = $query->latest()->paginate(20);
        
        $statuts = Dossier::select('statut')->distinct()->pluck('statut');
        $types = Dossier::select('type_affaire')->distinct()->pluck('type_affaire');
        
        return view('rapports.dossiers', compact('dossiers', 'statuts', 'types'));
    }

    public function restitutions(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $query = Restitution::with(['piece', 'piece.dossier']);

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $restitutions = $query->latest()->paginate(20);
        $statuts = Restitution::select('statut')->distinct()->pluck('statut');
        
        return view('rapports.restitutions', compact('restitutions', 'statuts'));
    }

    public function inventaires(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $query = Inventaire::with(['realisePar', 'verifiePar']);

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $inventaires = $query->latest()->paginate(20);
        $statuts = Inventaire::select('statut')->distinct()->pluck('statut');
        
        return view('rapports.inventaires', compact('inventaires', 'statuts'));
    }

   public function mouvements(Request $request)
{
    if (!Auth::user()->hasRole('admin')) {
        abort(403);
    }

    $query = Mouvement::with(['piece', 'fromEmplacement', 'toEmplacement']);

    // Filtrer par type
    if ($request->type) {
        $query->where('type', $request->type);
    }
    
    // Filtrer par date si besoin
    if ($request->date_debut) {
        $query->whereDate('date_mouvement', '>=', $request->date_debut);
    }
    if ($request->date_fin) {
        $query->whereDate('date_mouvement', '<=', $request->date_fin);
    }

    $mouvements = $query->latest('date_mouvement')->paginate(20);
    
    // Types disponibles
    $types = Mouvement::select('type')->distinct()->pluck('type');
    
    // Pas de statuts, on passe un tableau vide
    $statuts = collect([]);
    
    return view('rapports.mouvements', compact('mouvements', 'types', 'statuts'));
}

    public function exportPDF($type)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return redirect()->back()->with('info', 'Export PDF en cours de développement');
    }

    public function exportExcel($type)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return redirect()->back()->with('info', 'Export Excel en cours de développement');
    }

    private function calculerTauxOccupation()
    {
        $totalEmplacements = \App\Models\Emplacement::count();
        if ($totalEmplacements == 0) return 0;
        
        $emplacementsOccupes = \App\Models\Emplacement::has('pieces')->count();
        return round(($emplacementsOccupes / $totalEmplacements) * 100);
    }
}