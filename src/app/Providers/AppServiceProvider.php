<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

use Spatie\Export\Exporter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(Exporter $exporter)
    {
        $exporter->crawl(false);
        dd($exporter);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
