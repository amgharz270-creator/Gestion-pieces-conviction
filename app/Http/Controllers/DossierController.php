<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier;
use App\Models\User;

class DossierController extends Controller
{
   public function index()
{
    $dossiers = Dossier::with(['juge', 'pieces'])
        ->withCount('pieces')  
        ->latest()
        ->paginate(10);
    return view('dossiers.index', compact('dossiers'));
}

    public function create()
    {
        $juges = User::where('role', 'juge')->orWhere('role', 'admin')->get();
        return view('dossiers.create', compact('juges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_dossier' => 'required|unique:dossiers',
            'type_affaire' => 'required|in:penale,civile,commerciale,administrative',
            'parties' => 'required|string',
            'juge_id' => 'nullable|exists:users,id',
            'statut' => 'required|in:en_cours,juge,appel,cassation,clos',
            'date_ouverture' => 'required|date',
            'date_cloture' => 'nullable|date|after_or_equal:date_ouverture',
            'observations' => 'nullable|string',
        ]);

        Dossier::create($validated);

        return redirect()->route('dossiers.index')->with('success', 'Dossier créé avec succès');
    }

    public function show(Dossier $dossier)
    {
        $dossier->load(['juge', 'pieces']);
        return view('dossiers.show', compact('dossier'));
    }

    public function edit(Dossier $dossier)
    {
        $juges = User::where('role', 'juge')->orWhere('role', 'admin')->get();
        return view('dossiers.edit', compact('dossier', 'juges'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $validated = $request->validate([
            'numero_dossier' => 'required|unique:dossiers,numero_dossier,' . $dossier->id,
            'type_affaire' => 'required|in:penale,civile,commerciale,administrative',
            'parties' => 'required|string',
            'juge_id' => 'nullable|exists:users,id',
            'statut' => 'required|in:en_cours,juge,appel,cassation,clos',
            'date_ouverture' => 'required|date',
            'date_cloture' => 'nullable|date|after_or_equal:date_ouverture',
            'observations' => 'nullable|string',
        ]);

        $dossier->update($validated);

        return redirect()->route('dossiers.index')->with('success', 'Dossier mis à jour');
    }

    public function destroy(Dossier $dossier)
    {
        $dossier->delete();
        return redirect()->route('dossiers.index')->with('success', 'Dossier supprimé');
    }
}