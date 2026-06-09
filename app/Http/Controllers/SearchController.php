<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PieceConviction;
use App\Models\Dossier;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $results = [];
        
        // Rechercher dans les pièces
        $pieces = PieceConviction::where('reference', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();
        
        foreach ($pieces as $piece) {
            $results[] = [
                'title' => '🔍 Pièce: ' . $piece->reference,
                'url' => route('pieces.show', $piece)
            ];
        }
        
        // Rechercher dans les dossiers
        $dossiers = Dossier::where('numero_dossier', 'LIKE', "%{$query}%")
            ->orWhere('parties', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();
        
        foreach ($dossiers as $dossier) {
            $results[] = [
                'title' => '📁 Dossier: ' . $dossier->numero_dossier,
                'url' => route('dossiers.show', $dossier)
            ];
        }
        
        return response()->json($results);
    }
}