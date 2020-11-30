<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Location;
use Illuminate\Support\Facades\App;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('location',function(){
            return new Location();
        });
    }
}
