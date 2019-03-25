<?php

namespace AcDevelopers\Repository\Events;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use AcDevelopers\Repository\Contracts\RepositoryInterface;

/**
 * Class RepositoryEventBase
 * 
 * @package AcDevelopers\Repository\Events
 * @author Anitche Chisom
 */
abstract class RepositoryEventBase
{
    /**
     * @var EloquentModel
     */
    protected $model;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var string
     */
    protected $action;

    /**
     * RepositoryEventBase Constructor
     * 
     * @param RepositoryInterface $repository
     * @param EloquentModel               $model
     */
    public function __construct(RepositoryInterface $repository, EloquentModel $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Get EloquentModel
     * 
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get RepositoryInterface
     * 
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get Action
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}
