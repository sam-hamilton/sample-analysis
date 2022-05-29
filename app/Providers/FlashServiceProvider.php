<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Flash::levels([
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'error' => 'alert-error',
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
