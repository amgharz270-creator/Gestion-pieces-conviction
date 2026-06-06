<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        // Vérification manuelle au lieu de middleware
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Seul l\'administrateur peut gérer les rôles.');
        }
        
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès');
    }

    public function edit(Role $role)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rôle mis à jour');
    }

    public function destroy(Role $role)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé');
    }
}