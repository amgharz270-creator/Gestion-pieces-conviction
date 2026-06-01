<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emplacement;

class EmplacementController extends Controller
{
    public function index()
    {
        $emplacements = Emplacement::withCount('pieces')->latest()->paginate(10);
        return view('emplacements.index', compact('emplacements'));
    }

    public function create()
    {
        return view('emplacements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'local' => 'required|string|max:100',
            'armoire' => 'required|string|max:100',
            'etagere' => 'nullable|string|max:100',
            'boite' => 'nullable|string|max:100',
            'capacite_max' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:2000',
            'actif' => 'boolean',
        ]);

        $validated['actif'] = $request->boolean('actif', true);
        $validated['pieces_actuelles'] = 0;

        Emplacement::create($validated);

        return redirect()->route('emplacements.index')->with('success', 'Emplacement créé avec succès');
    }

    public function show(Emplacement $emplacement)
    {
        $emplacement->load(['pieces.dossier']);
        return view('emplacements.show', compact('emplacement'));
    }

    public function edit(Emplacement $emplacement)
    {
        return view('emplacements.edit', compact('emplacement'));
    }

    public function update(Request $request, Emplacement $emplacement)
    {
        $validated = $request->validate([
            'local' => 'required|string|max:100',
            'armoire' => 'required|string|max:100',
            'etagere' => 'nullable|string|max:100',
            'boite' => 'nullable|string|max:100',
            'capacite_max' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:2000',
            'actif' => 'boolean',
        ]);

        $validated['actif'] = $request->boolean('actif', true);

        $emplacement->update($validated);

        return redirect()->route('emplacements.index')->with('success', 'Emplacement mis à jour');
    }

    public function destroy(Emplacement $emplacement)
    {
        if ($emplacement->pieces()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des pièces sont encore stockées ici');
        }
        
        $emplacement->delete();
        return redirect()->route('emplacements.index')->with('success', 'Emplacement supprimé');
    }
}

