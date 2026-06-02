<?php

namespace App\Http\Controllers;

use App\Models\PieceConviction;
use App\Models\Dossier;
use App\Models\Restitution;

class HomeController extends Controller
{
    public function index()
    {
        
        $piecesCount = PieceConviction::count();           
        $dossiersCount = Dossier::where('statut', 'en_cours')->count();  
        $restitutionsCount = Restitution::count();         
        
        $securityRate = '99%';  
        
        return view('welcome', compact('piecesCount', 'dossiersCount', 'restitutionsCount', 'securityRate'));
    }
}