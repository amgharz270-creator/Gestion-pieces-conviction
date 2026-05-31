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
        // ⭐ HNA TKTBO LES REQUÊTES SQL
        $piecesCount = PieceConviction::count();
        $dossiersCount = Dossier::where('statut', 'en_cours')->count();
        $restitutionsCount = Restitution::whereMonth('created_at', now()->month)->count();
        $usersCount = User::count();
        
        // Pièces récentes (5 dernières)
        $recentPieces = PieceConviction::with(['dossier', 'emplacement'])
            ->latest()->take(5)->get();
        
        // Activité récente
        $recentActivity = Mouvement::with(['piece', 'fromUser', 'toUser'])
            ->latest()->take(10)->get();
        
        // Alertes
        $pendingRestitutions = Restitution::where('statut', 'en_attente')
            ->where('created_at', '<', now()->subDays(30))->count();
        
        $expiringPieces = PieceConviction::whereNotNull('date_peremption')
            ->where('date_peremption', '<=', now()->addDays(7))
            ->where('date_peremption', '>=', now())->count();
        
        // Données pour le graphique (6 derniers mois)
        $chartData = [];
for ($i = 5; $i >= 0; $i--) {
    $month = now()->subMonths($i);
    $chartData[] = [
        'mois' => $month->format('M Y'),
        'pieces' => PieceConviction::whereMonth('created_at', $month->month)
            ->whereYear('created_at', $month->year)->count(),
        'restitutions' => Restitution::whereMonth('created_at', $month->month)
            ->whereYear('created_at', $month->year)->count(),
    ];
}
        
        // Emplacements avec capacité
        $emplacements = Emplacement::withCount('pieces')->get();
        
        // ⭐ HNA TREJ3 LES VARIABLES LBLADE
        return view('dashboard', compact(
            'piecesCount', 'dossiersCount', 'restitutionsCount', 'usersCount',
            'recentPieces', 'recentActivity', 'pendingRestitutions', 
            'expiringPieces', 'chartData', 'emplacements'
        ));
    }
}