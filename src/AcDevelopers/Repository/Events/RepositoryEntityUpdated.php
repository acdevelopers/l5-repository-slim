<?php

namespace AcDevelopers\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 * 
 * @package AcDevelopers\Repository\Events
 * @author Anitche Chisom
 */
class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updated";
}
