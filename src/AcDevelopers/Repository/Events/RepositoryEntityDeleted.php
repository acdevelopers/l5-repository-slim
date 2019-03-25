<?php

namespace AcDevelopers\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 * 
 * @package AcDevelopers\Repository\Events
 * @author Anitche Chisom
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
