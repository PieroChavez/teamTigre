<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Plan Mensual',
                'duration_days' => 30,
                'price' => 120.00,
            ],
            [
                'name' => 'Plan Trimestral',
                'duration_days' => 90,
                'price' => 330.00,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::firstOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}
