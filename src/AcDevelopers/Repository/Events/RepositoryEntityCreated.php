<?php

namespace AcDevelopers\Repository\Events;

/**
 * Class RepositoryEntityCreated
 * 
 * @package AcDevelopers\Repository\Events
 * @author Anitche Chisom
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "created";
}
