<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restitution;
use App\Models\PieceConviction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RestitutionController extends Controller
{
    public function index()
    {
        $restitutions = Restitution::with(['piece', 'approvedBy'])
            ->latest()
            ->paginate(10);
        return view('restitutions.index', compact('restitutions'));
    }

    public function create()
    {
        $pieces = PieceConviction::whereIn('statut', ['depot', 'saisie'])->get();
        return view('restitutions.create', compact('pieces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'piece_id' => 'required|exists:pieces_conviction,id',
            'demandeur_nom' => 'required|string|max:255',
            'demandeur_cin' => 'nullable|string|max:20',
            'type_demandeur' => 'required|in:victime,prevenu,tiers,avocat,heritier',
            'motif_demande' => 'required|string|max:2000',
            'jugement_reference' => 'nullable|string|max:255',
            'date_jugement' => 'nullable|date',
        ]);

        $restitution = Restitution::create([
            ...$validated,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('restitutions.index')
            ->with('success', 'Demande de restitution créée avec succès');
    }

    public function show(Restitution $restitution)
    {
        $restitution->load(['piece.dossier', 'approvedBy']);
        return view('restitutions.show', compact('restitution'));
    }

    public function edit(Restitution $restitution)
    {
        $pieces = PieceConviction::all();
        return view('restitutions.edit', compact('restitution', 'pieces'));
    }

    public function update(Request $request, Restitution $restitution)
    {
        $validated = $request->validate([
            'piece_id' => 'required|exists:pieces_conviction,id',
            'demandeur_nom' => 'required|string|max:255',
            'demandeur_cin' => 'nullable|string|max:20',
            'type_demandeur' => 'required|in:victime,prevenu,tiers,avocat,heritier',
            'motif_demande' => 'required|string|max:2000',
            'jugement_reference' => 'nullable|string|max:255',
            'date_jugement' => 'nullable|date',
            'statut' => 'required|in:en_attente,approuvee,refusee,effectuee',
            'receveur_nom' => 'nullable|string|max:255',
            'receveur_cin' => 'nullable|string|max:20',
            'observations' => 'nullable|string|max:2000',
        ]);

        // Si approbation
        if ($validated['statut'] == 'approuvee' && $restitution->statut != 'approuvee') {
            $validated['approuve_par'] = Auth::id();
            $validated['date_approbation'] = now();
        }

        // Si restitution effectuée
        if ($validated['statut'] == 'effectuee' && $restitution->statut != 'effectuee') {
            $validated['date_restitution'] = now();
            // Mettre à jour le statut de la pièce
            $restitution->piece->update(['statut' => 'restituee']);
        }

        $restitution->update($validated);

        return redirect()->route('restitutions.index')
            ->with('success', 'Restitution mise à jour avec succès');
    }

    public function destroy(Restitution $restitution)
    {
        $restitution->delete();
        return redirect()->route('restitutions.index')
            ->with('success', 'Restitution supprimée');
    }

    // Approuver une restitution
    public function approuver(Restitution $restitution)
    {
        $restitution->update([
            'statut' => 'approuvee',
            'approuve_par' => Auth::id(),
            'date_approbation' => now(),
        ]);

        return back()->with('success', 'Restitution approuvée');
    }

    // Effectuer une restitution
    public function effectuer(Request $request, Restitution $restitution)
    {
        $validated = $request->validate([
            'receveur_nom' => 'required|string|max:255',
            'receveur_cin' => 'required|string|max:20',
            'observations' => 'nullable|string',
        ]);

        $restitution->update([
            ...$validated,
            'statut' => 'effectuee',
            'date_restitution' => now(),
        ]);

        $restitution->piece->update(['statut' => 'restituee']);

        return back()->with('success', 'Restitution effectuée avec succès');
    }
}