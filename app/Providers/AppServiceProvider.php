<?php

namespace App\Providers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerFilestackSdk();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Factory $validator)
    {
        //
    }

    /**
     * Register les class sdk filestack
     */
    private function registerFilestackSdk()
    {
        //FilestackSecurity
        $this->app->singleton(FilestackSecurity::class, function (Application $app, array $parameters)
        {
            return new FilestackSecurity('');
        });
        // FilestackClient
        $this->app->singleton(FilestackClient::class, function (Application $app, array $parameters)
        {
            return new FilestackClient('', app(FilestackSecurity::class));
        });
        // Filelink
        $this->app->singleton(Filelink::class, function (Application $app, array $parameters)
        {
            return new Filelink($parameters['handle'], '', app(FilestackSecurity::class));
        });
    }
}
