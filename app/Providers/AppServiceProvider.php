<?php

namespace App\Providers;

use App\View\Components\articleDetails;
use App\View\Components\ImageImport;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::component('image-impor', ImageImport::class);
        Blade::component('article-details', articleDetails::class);
    }
}
