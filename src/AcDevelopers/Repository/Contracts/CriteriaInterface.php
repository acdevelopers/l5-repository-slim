<?php

namespace AcDevelopers\Repository\Contracts;

use AcDevelopers\Repository\Contracts\RepositoryInterface;

/**
 * interface RequestCriteria
 * 
 * @package AcDevelopers\Repository\Criteria
 * @author Anitche Chisom
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
