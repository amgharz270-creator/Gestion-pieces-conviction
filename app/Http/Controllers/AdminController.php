<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PieceConviction;
use App\Models\Dossier;
use App\Models\Restitution;
use App\Models\Mouvement;
use App\Models\User;
use App\Models\Emplacement;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ========== STATISTIQUES PRINCIPALES ==========
        $piecesCount = PieceConviction::count();
        $dossiersCount = Dossier::count();  // Ila baghi les dossiers "en_cours" seul, dir: Dossier::where('statut', 'en_cours')->count()
        $restitutionsCount = Restitution::whereMonth('created_at', now()->month)->count();  // Restitutions d had l mois
        $usersCount = User::count();
        
        // ========== PIECES RECENTES ==========
        $recentPieces = PieceConviction::with(['dossier', 'emplacement'])
            ->latest()
            ->take(5)
            ->get();
        
        // ========== ACTIVITE RECENTE ==========
        $recentActivity = Mouvement::with(['piece', 'fromUser', 'toUser'])
            ->latest()
            ->take(10)
            ->get();
        
        // ========== ALERTES ==========
        // Restitutions en attente depuis plus de 30 jours
        $pendingRestitutions = Restitution::where('statut', 'en_attente')
            ->where('created_at', '<', now()->subDays(30))
            ->count();
        
        // Pièces qui expirent dans les 7 prochains jours
        $expiringPieces = PieceConviction::whereNotNull('date_peremption')
            ->where('date_peremption', '<=', now()->addDays(7))
            ->where('date_peremption', '>=', now())
            ->count();
        
        // ========== GRAPHIQUE (6 derniers mois) ==========
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartData[] = [
                'mois' => $month->format('M Y'),
                'pieces' => PieceConviction::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'restitutions' => Restitution::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
            ];
        }
        
        // ========== EMPLACEMENTS AVEC NOMBRE DE PIECES ==========
        $emplacements = Emplacement::withCount('pieces')->get();
        
        // ========== RETOUR VERS LA VUE ==========
        return view('dashboard', compact(
            'piecesCount',
            'dossiersCount', 
            'restitutionsCount',
            'usersCount',
            'recentPieces',
            'recentActivity',
            'pendingRestitutions',
            'expiringPieces',
            'chartData',
            'emplacements'
        ));
        // ========== STATS SUPPLEMENTAIRES ==========
$piecesByStatus = PieceConviction::select('statut', \DB::raw('count(*) as total'))
    ->groupBy('statut')
    ->get();

$piecesByCategory = PieceConviction::select('categorie', \DB::raw('count(*) as total'))
    ->groupBy('categorie')
    ->get();

$topEmplacements = Emplacement::withCount('pieces')
    ->orderBy('pieces_count', 'desc')
    ->take(5)
    ->get();
    }
}