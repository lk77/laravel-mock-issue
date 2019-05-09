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
        $this->app->singleton(File::class, function (Application $app, array $parameters)
        {
            return new File();
        });
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
}
