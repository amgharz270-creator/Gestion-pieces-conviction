<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SpatiePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            // Pièces
            'view_pieces', 'create_pieces', 'edit_pieces', 'delete_pieces',
            // Dossiers
            'view_dossiers', 'create_dossiers', 'edit_dossiers', 'delete_dossiers',
            // Emplacements
            'view_emplacements', 'create_emplacements', 'edit_emplacements', 'delete_emplacements',
            // Restitutions
            'view_restitutions', 'create_restitutions', 'approve_restitutions',
            // Inventaires
            'view_inventaires', 'create_inventaires', 'manage_inventaires',
            // Mouvements
            'view_mouvements', 'create_mouvements',
            // Utilisateurs
            'manage_users', 'view_users',
            // Rapports
            'view_reports', 'export_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Créer les rôles
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleResponsableArgent = Role::firstOrCreate(['name' => 'responsable_argent', 'guard_name' => 'web']);
        $roleResponsableArgent->givePermissionTo([
            'view_pieces', 'create_pieces', 'edit_pieces',
            'view_dossiers', 'view_restitutions', 'create_restitutions',
            'view_inventaires', 'view_mouvements', 'create_mouvements',
        ]);

        $roleResponsableDestruction = Role::firstOrCreate(['name' => 'responsable_destruction', 'guard_name' => 'web']);
        $roleResponsableDestruction->givePermissionTo([
            'view_pieces', 'create_pieces', 'edit_pieces',
            'view_dossiers', 'view_restitutions', 'create_restitutions',
            'view_inventaires', 'view_mouvements', 'create_mouvements',
        ]);

        $roleResponsableConservation = Role::firstOrCreate(['name' => 'responsable_conservation', 'guard_name' => 'web']);
        $roleResponsableConservation->givePermissionTo([
            'view_pieces', 'create_pieces', 'edit_pieces',
            'view_dossiers', 'view_restitutions', 'create_restitutions',
            'view_inventaires', 'view_mouvements', 'create_mouvements',
        ]);

        // Assigner le rôle admin à l'utilisateur ID 1
        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}