<?php

namespace App\Providers;

use App\Models\SiteSettings;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
    * Register any application services.
    *
    * @return void
    */

    public function register() {
        //
    }

    /**
    * Bootstrap any application services.
    *
    * @return void
    */

    public function boot() {
        if ( SiteSettings::find( 1 ) ) {
            $siteSettings = SiteSettings::findOrFail( 1 );
            view()->share( 'siteSettings', $siteSettings );
        }
    }
}
