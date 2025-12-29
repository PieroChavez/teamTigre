<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buscar el rol admin
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->command->error('El rol admin no existe.');
            return;
        }

        // 2. Crear o actualizar el usuario admin
        User::firstOrCreate(
            ['email' => 'admin@sistemabox.com'],
            [
                'name'     => 'Administrador',
                'role_id'  => $adminRole->id,
                'password' => Hash::make('password123'),
                'status'   => 'active',
            ]
        );
    }
}
