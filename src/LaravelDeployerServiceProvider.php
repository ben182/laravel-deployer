<?php

namespace Ben182\LaravelDeployer;

use Illuminate\Support\ServiceProvider;
use Ben182\LaravelDeployer\Commands\DeployInfo;

class LaravelDeployerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-deployer');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-deployer');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $old = config('deploy.include');
        config([
            'deploy.include' => array_merge($old, [
                'vendor/ben182/laravel-deployer/recipes.php',
            ])
        ]);

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__.'/../config/config.php' => config_path('laravel-deployer.php'),
            // ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-deployer'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-deployer'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-deployer'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                DeployInfo::class,
                \Bugsnag\BugsnagLaravel\Commands\DeployCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        // $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-deployer');

        // // Register the main class to use with the facade
        // $this->app->singleton('laravel-deployer', function () {
        //     return new LaravelDeployer;
        // });
    }
}
