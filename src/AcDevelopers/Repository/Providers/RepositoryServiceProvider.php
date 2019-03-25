<?php

namespace AcDevelopers\Repository\Providers;

use AcDevelopers\Repository\Providers\EventServiceProvider;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @package AcDevelopers\Repository\Providers
 * @author Anitche Chisom
 */
class RepositoryServiceProvider extends LaravelServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../../config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../../../config/repository.php', 'repository');

        $this->loadTranslationsFrom(__DIR__ . '/../../../../lang', 'repository');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('AcDevelopers\Repository\Generators\Commands\RepositoryCommand');
        $this->commands('AcDevelopers\Repository\Generators\Commands\EntityCommand');
        $this->commands('AcDevelopers\Repository\Generators\Commands\ControllerCommand');
        $this->commands('AcDevelopers\Repository\Generators\Commands\BindingsCommand');
        $this->commands('AcDevelopers\Repository\Generators\Commands\CriteriaCommand');
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
