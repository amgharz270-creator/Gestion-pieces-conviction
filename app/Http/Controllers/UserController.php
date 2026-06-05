<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   public function index()
{
    // Vérifier si l'utilisateur a le rôle 'admin' via Spatie
    if (!Auth::user()->hasRole('admin')) {
        abort(403, 'Seul l\'administrateur peut gérer les utilisateurs.');
    }

    $users = User::latest()->paginate(10);
    return view('users.index', compact('users'));
}

    public function create()
    {
        if (Auth::user()->role_special !== 'admin') {
            abort(403);
        }
        
        $rolesSpeciaux = User::getRolesSpeciaux();
        return view('users.create', compact('rolesSpeciaux'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_special !== 'admin') {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_special' => 'required|in:admin,responsable_argent,responsable_destruction,responsable_conservation',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_special' => $validated['role_special'],
            'role' => 'user',
            'password' => Hash::make($validated['password']),
            'actif' => true,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur "' . $user->name . '" créé avec succès');
    }

    public function show(User $user)
    {
        if (Auth::user()->role_special !== 'admin') {
            abort(403);
        }
        
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (Auth::user()->role_special !== 'admin') {
            abort(403);
        }
        
        $rolesSpeciaux = User::getRolesSpeciaux();
        return view('users.edit', compact('user', 'rolesSpeciaux'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role_special !== 'admin') {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_special' => 'required|in:admin,responsable_argent,responsable_destruction,responsable_conservation',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur "' . $user->name . '" mis à jour');
    }

    public function updatePassword(Request $request, User $user)
    {
        if (Auth::user()->role_special !== 'admin') {
            abort(403);
        }
        
        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('users.show', $user)
            ->with('success', 'Mot de passe modifié');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->role_special !== 'admin') {
            abort(403);
        }
        
        if (Auth::user()->id == $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur "' . $name . '" supprimé');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('users.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('users.profile')
            ->with('success', 'Profil mis à jour');
    }

    public function updateOwnPassword(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Mot de passe actuel incorrect');
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('users.profile')
            ->with('success', 'Mot de passe modifié');
    }
}