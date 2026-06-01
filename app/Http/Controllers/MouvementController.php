<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mouvement;
use App\Models\PieceConviction;
use App\Models\Emplacement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MouvementController extends Controller
{
    public function index()
    {
        $mouvements = Mouvement::with(['piece', 'fromUser', 'toUser', 'fromEmplacement', 'toEmplacement'])
            ->latest()
            ->paginate(10);
        return view('mouvements.index', compact('mouvements'));
    }

    public function create()
    {
        $pieces = PieceConviction::whereIn('statut', ['depot', 'saisie', 'expertise'])->get();
        $emplacements = Emplacement::where('actif', true)->get();
        $users = User::all();
        return view('mouvements.create', compact('pieces', 'emplacements', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'piece_id' => 'required|exists:pieces_conviction,id',
            'to_user_id' => 'required|exists:users,id',
            'from_emplacement_id' => 'nullable|exists:emplacements,id',
            'to_emplacement_id' => 'nullable|exists:emplacements,id',
            'type' => 'required|in:saisie,transfert,restitution,destruction,vente,expertise,audience,retour_depot',
            'motif' => 'nullable|string|max:2000',
            'document_reference' => 'nullable|string|max:255',
            'date_mouvement' => 'required|date',
            'date_retour_prevue' => 'nullable|date|after_or_equal:date_mouvement',
            'observations' => 'nullable|string|max:2000',
        ]);

        $piece = PieceConviction::find($validated['piece_id']);

        $mouvement = Mouvement::create([
            ...$validated,
            'from_user_id' => Auth::id(),
            'from_emplacement_id' => $piece->emplacement_id,
        ]);

        if ($validated['to_emplacement_id']) {
            $oldEmplacementId = $piece->emplacement_id;
            $piece->update(['emplacement_id' => $validated['to_emplacement_id']]);
            if ($oldEmplacementId) {
                Emplacement::find($oldEmplacementId)->decrement('pieces_actuelles');
            }
            Emplacement::find($validated['to_emplacement_id'])->increment('pieces_actuelles');
        }

        $statusMap = [
            'restitution' => 'restituee',
            'destruction' => 'detruite',
            'vente' => 'vendue',
            'expertise' => 'expertise',
            'retour_depot' => 'depot',
        ];

        if (isset($statusMap[$validated['type']])) {
            $piece->update(['statut' => $statusMap[$validated['type']]]);
        }

        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement enregistre avec succes');
    }

    public function show(Mouvement $mouvement)
    {
        $mouvement->load(['piece.dossier', 'fromUser', 'toUser', 'fromEmplacement', 'toEmplacement']);
        return view('mouvements.show', compact('mouvement'));
    }

    public function edit(Mouvement $mouvement)
    {
        $pieces = PieceConviction::all();
        $emplacements = Emplacement::where('actif', true)->get();
        $users = User::all();
        return view('mouvements.edit', compact('mouvement', 'pieces', 'emplacements', 'users'));
    }

    public function update(Request $request, Mouvement $mouvement)
    {
        $validated = $request->validate([
            'piece_id' => 'required|exists:pieces_conviction,id',
            'to_user_id' => 'required|exists:users,id',
            'to_emplacement_id' => 'nullable|exists:emplacements,id',
            'type' => 'required|in:saisie,transfert,restitution,destruction,vente,expertise,audience,retour_depot',
            'motif' => 'nullable|string|max:2000',
            'document_reference' => 'nullable|string|max:255',
            'date_mouvement' => 'required|date',
            'date_retour_prevue' => 'nullable|date|after_or_equal:date_mouvement',
            'date_retour_effective' => 'nullable|date|after_or_equal:date_mouvement',
            'observations' => 'nullable|string|max:2000',
        ]);

        $mouvement->update($validated);

        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement mis a jour avec succes');
    }

    public function destroy(Mouvement $mouvement)
    {
        $mouvement->delete();
        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement supprime');
    }

    public function retour(Mouvement $mouvement)
    {
        $mouvement->update([
            'date_retour_effective' => now(),
        ]);

        $mouvement->piece->update(['statut' => 'depot']);

        return back()->with('success', 'Retour enregistre avec succes');
    }
}