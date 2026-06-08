<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Unit;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Set locale Indonesia untuk Carbon (translatedFormat)
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8', 'id_ID', 'id');

        if (app()->isProduction() || env('VERCEL')) {
            URL::forceScheme('https');
        }

        // Route model binding untuk Unit
        Route::model('unit', Unit::class);
    }
}
