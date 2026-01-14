<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ================================================
        // Llamar a los seeders que quieras ejecutar
        // ================================================
        $this->call([
            // Si tienes un seeder de roles
            RoleSeeder::class,

            // Seeder principal de Academia: usuarios, docentes y periodos
            AcademiaSeeder::class,

            // Otros seeders que tengas
            // OtroSeeder::class,
        ]);
    }
}
