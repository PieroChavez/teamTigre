<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'ventas',
            'docente',
            'alumno',
            'cliente',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['nombre' => $role]);
        }
    }
}
