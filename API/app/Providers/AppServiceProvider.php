<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\PersonalAccessToken; // Importa correctamente el modelo
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Usa el modelo correcto para los tokens de acceso personal de Sanctum
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
