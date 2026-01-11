<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@datacenter.local'],
            ['name' => 'Admin DataCenter', 'password' => Hash::make('password'), 'role' => 'admin', 'is_active' => true]
        );

        User::updateOrCreate(
            ['email' => 'manager@datacenter.local'],
            ['name' => 'Responsable Ressources', 'password' => Hash::make('password'), 'role' => 'manager', 'is_active' => true]
        );

        User::updateOrCreate(
            ['email' => 'user@datacenter.local'],
            ['name' => 'Utilisateur Interne', 'password' => Hash::make('password'), 'role' => 'user', 'is_active' => true]
        );
    }
}
