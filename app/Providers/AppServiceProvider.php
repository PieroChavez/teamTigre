<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 👈 1. Importar la clase Paginator

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. 🎯 Configurar Laravel para que use los estilos de Tailwind CSS 
        //    para renderizar los enlaces de paginación.
        Paginator::useTailwind();
    }
}