<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
{
    $categorias = [
        ['nombre' => 'Box Kids', 'edad_min' => 4, 'edad_max' => 10],
        ['nombre' => 'Box Junior', 'edad_min' => 11, 'edad_max' => 17],
        ['nombre' => 'Box Juvenil', 'edad_min' => 18, 'edad_max' => 35],
        ['nombre' => 'Box Master', 'edad_min' => 36, 'edad_max' => null],
        ['nombre' => 'Box Femenino', 'edad_min' => 15, 'edad_max' => null],
    ];

    foreach ($categorias as $categoria) {
        Categoria::updateOrCreate(
            ['nombre' => $categoria['nombre']], // condición
            $categoria
        );
    }
}

}
