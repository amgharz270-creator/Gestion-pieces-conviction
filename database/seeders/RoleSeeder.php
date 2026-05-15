<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Le premier utilisateur devient admin
        $firstUser = User::first();
        if ($firstUser) {
            $firstUser->update(['role' => 'admin']);
            echo "Utilisateur " . $firstUser->name . " est maintenant ADMIN\n";
        }

        // Les autres deviennent magasinier
        User::whereNull('role')->update(['role' => 'magasinier']);
        echo "Tous les autres utilisateurs sont MAGASINIER\n";
    }
}