<?php

namespace AcDevelopers\Repository\Providers;

use AcDevelopers\Repository\Events\RepositoryEntityCreated;
use AcDevelopers\Repository\Events\RepositoryEntityDeleted;
use AcDevelopers\Repository\Events\RepositoryEntityUpdated;
use AcDevelopers\Repository\Listeners\CleanCacheRepository;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package AcDevelopers\Repository\Providers
 * @author Anitche Chisom
 */
class EventServiceProvider extends LaravelServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RepositoryEntityCreated::class => [
            CleanCacheRepository::class
        ],
        RepositoryEntityUpdated::class => [
            CleanCacheRepository::class
        ],
        RepositoryEntityDeleted::class => [
            CleanCacheRepository::class
        ]
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        $events = app('events');

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
