<?php

namespace AcDevelopers\Repository\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use AcDevelopers\Repository\Commands\RepositoryGenerator;

/**
 * Class LumenRepositoryServiceProvider
 *
 * @package AcDevelopers\Repository\Providers
 * @author Anitche Chisom
 */
class LumenRepositoryServiceProvider extends LaravelServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(RepositoryGenerator::class);
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
