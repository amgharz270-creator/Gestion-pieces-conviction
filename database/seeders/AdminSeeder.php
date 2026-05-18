<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tpi.ma'],
            [
                'name' => 'Administrateur TPI',
                'email' => 'admin@tpi.ma',
                
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}