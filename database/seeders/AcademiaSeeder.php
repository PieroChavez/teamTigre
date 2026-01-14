<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AcademiaSeeder extends Seeder
{
    public function run()
    {
        // ================================================
        // 1️⃣ Roles
        // ================================================
        $roles = [
            ['id' => 1, 'nombre' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Docente', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Estudiante', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Limpiar roles duplicados por nombre antes de upsert
        DB::table('roles')
            ->whereIn('nombre', array_column($roles, 'nombre'))
            ->delete();

        DB::table('roles')->upsert(
            $roles,
            ['nombre'],
            ['updated_at']
        );

        // ================================================
        // 2️⃣ Usuarios
        // ================================================
        $usuarios = [
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('admin123'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Docente 1', 'email' => 'docente1@example.com', 'password' => Hash::make('docente123'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Docente 2', 'email' => 'docente2@example.com', 'password' => Hash::make('docente123'), 'created_at' => now(), 'updated_at' => now()],
        ];

        // Limpiar duplicados por email
        DB::table('users')
            ->whereIn('email', array_column($usuarios, 'email'))
            ->delete();

        DB::table('users')->upsert(
            $usuarios,
            ['email'],
            ['name', 'password', 'updated_at']
        );

        // ================================================
        // 3️⃣ Docentes 
        // ================================================
        $docentes = [
            [
                'user_id' => 2, 
                'dni' => '00000001A', 
                'especialidad' => 'Boxeo Infantil', 
                'experiencia' => '3 años enseñando boxeo a niños y jóvenes', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'dni' => '00000002B', 
                'especialidad' => 'Boxeo Avanzado', 
                'experiencia' => '5 años de experiencia en entrenamiento profesional', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ];

        // Limpiar duplicados por user_id
        DB::table('docentes')
            ->whereIn('user_id', array_column($docentes, 'user_id'))
            ->delete();

        DB::table('docentes')->upsert(
            $docentes,
            ['user_id'],
            ['dni', 'especialidad', 'experiencia', 'updated_at'] 
        );

        // ================================================
        // 4️⃣ Plantilla de periodos (¡CORREGIDO: Se elimina 'semanas'!)
        // ================================================
        $periodos = [
            ['nombre' => '1 Mes', 'duracion_meses' => 1, 'duracion_semanas' => 4, 'precio_base' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '3 Meses', 'duracion_meses' => 3, 'duracion_semanas' => 12, 'precio_base' => 140, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '6 Meses', 'duracion_meses' => 6, 'duracion_semanas' => 24, 'precio_base' => 270, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '12 Meses', 'duracion_meses' => 12, 'duracion_semanas' => 48, 'precio_base' => 500, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Limpiar duplicados por nombre
        DB::table('plantilla_periodos')
            ->whereIn('nombre', array_column($periodos, 'nombre'))
            ->delete();

        DB::table('plantilla_periodos')->upsert(
            $periodos,
            ['nombre'],
            ['duracion_meses', 'duracion_semanas', 'precio_base', 'updated_at'] // 'semanas' eliminado de la lista de campos a actualizar
        );
    }
}