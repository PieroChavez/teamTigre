<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Boxeo Niños',
                'level' => 'Inicial',
                'type' => 'Niños',
            ],
            [
                'name' => 'Boxeo Juvenil',
                'level' => 'Intermedio',
                'type' => 'Juveniles',
            ],
            [
                'name' => 'Boxeo Adultos',
                'level' => 'Avanzado',
                'type' => 'Adultos',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
