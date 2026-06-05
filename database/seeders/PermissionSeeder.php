<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Liste des permissions
        $permissions = [
            // Pièces
            ['name' => 'view_pieces', 'label' => 'Voir les pièces', 'categorie' => 'pieces'],
            ['name' => 'create_pieces', 'label' => 'Créer des pièces', 'categorie' => 'pieces'],
            ['name' => 'edit_pieces', 'label' => 'Modifier des pièces', 'categorie' => 'pieces'],
            ['name' => 'delete_pieces', 'label' => 'Supprimer des pièces', 'categorie' => 'pieces'],
            
            // Dossiers
            ['name' => 'view_dossiers', 'label' => 'Voir les dossiers', 'categorie' => 'dossiers'],
            ['name' => 'create_dossiers', 'label' => 'Créer des dossiers', 'categorie' => 'dossiers'],
            ['name' => 'edit_dossiers', 'label' => 'Modifier des dossiers', 'categorie' => 'dossiers'],
            ['name' => 'delete_dossiers', 'label' => 'Supprimer des dossiers', 'categorie' => 'dossiers'],
            
            // Emplacements
            ['name' => 'view_emplacements', 'label' => 'Voir les emplacements', 'categorie' => 'emplacements'],
            ['name' => 'create_emplacements', 'label' => 'Créer des emplacements', 'categorie' => 'emplacements'],
            ['name' => 'edit_emplacements', 'label' => 'Modifier des emplacements', 'categorie' => 'emplacements'],
            ['name' => 'delete_emplacements', 'label' => 'Supprimer des emplacements', 'categorie' => 'emplacements'],
            
            // Restitutions
            ['name' => 'view_restitutions', 'label' => 'Voir les restitutions', 'categorie' => 'restitutions'],
            ['name' => 'create_restitutions', 'label' => 'Créer des demandes', 'categorie' => 'restitutions'],
            ['name' => 'approve_restitutions', 'label' => 'Approuver les restitutions', 'categorie' => 'restitutions'],
            
            // Inventaires
            ['name' => 'view_inventaires', 'label' => 'Voir les inventaires', 'categorie' => 'inventaires'],
            ['name' => 'create_inventaires', 'label' => 'Créer des inventaires', 'categorie' => 'inventaires'],
            ['name' => 'manage_inventaires', 'label' => 'Gérer les inventaires', 'categorie' => 'inventaires'],
            
            // Mouvements
            ['name' => 'view_mouvements', 'label' => 'Voir les mouvements', 'categorie' => 'mouvements'],
            ['name' => 'create_mouvements', 'label' => 'Créer des mouvements', 'categorie' => 'mouvements'],
            
            // Utilisateurs
            ['name' => 'manage_users', 'label' => 'Gérer les utilisateurs', 'categorie' => 'users'],
            ['name' => 'view_users', 'label' => 'Voir les utilisateurs', 'categorie' => 'users'],
            
            // Rapports
            ['name' => 'view_reports', 'label' => 'Voir les rapports', 'categorie' => 'reports'],
            ['name' => 'export_reports', 'label' => 'Exporter les rapports', 'categorie' => 'reports'],
        ];
        
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }
        
        // Attribution des permissions par rôle
        $rolePermissions = [
            'admin' => [
                'view_pieces', 'create_pieces', 'edit_pieces', 'delete_pieces',
                'view_dossiers', 'create_dossiers', 'edit_dossiers', 'delete_dossiers',
                'view_emplacements', 'create_emplacements', 'edit_emplacements', 'delete_emplacements',
                'view_restitutions', 'create_restitutions', 'approve_restitutions',
                'view_inventaires', 'create_inventaires', 'manage_inventaires',
                'view_mouvements', 'create_mouvements',
                'manage_users', 'view_users',
                'view_reports', 'export_reports'
            ],
            'responsable_argent' => [
                'view_pieces', 'create_pieces', 'edit_pieces',
                'view_dossiers',
                'view_restitutions', 'create_restitutions',
                'view_inventaires',
                'view_mouvements', 'create_mouvements',
            ],
            'responsable_destruction' => [
                'view_pieces', 'create_pieces', 'edit_pieces',
                'view_dossiers',
                'view_restitutions', 'create_restitutions',
                'view_inventaires',
                'view_mouvements', 'create_mouvements',
            ],
            'responsable_conservation' => [
                'view_pieces', 'create_pieces', 'edit_pieces',
                'view_dossiers',
                'view_restitutions', 'create_restitutions',
                'view_inventaires',
                'view_mouvements', 'create_mouvements',
            ],
        ];
        
        foreach ($rolePermissions as $role => $perms) {
            foreach ($perms as $permName) {
                $permission = Permission::where('name', $permName)->first();
                if ($permission) {
                    DB::table('role_permissions')->updateOrInsert(
                        ['role_special' => $role, 'permission_id' => $permission->id],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }
        }
    }
}