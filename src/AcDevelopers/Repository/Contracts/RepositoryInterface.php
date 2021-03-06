<?php

namespace AcDevelopers\Repository\Contracts;

/**
 * Class RepositoryInterface
 * 
 * @package AcDeveloper/Repository/Contracts
 * @author Anitche Chisom
 */
interface RepositoryInterface
{
    /**
     * Retrieve data array for populate field select
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($column, $key = null);

    /**
     * Retrieve data array for populate field select
     * Compatible with Laravel 5.3
     * 
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function pluck($column, $key = null);

    /**
     * Sync relations
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @param bool $detaching
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true);

    /**
     * SyncWithoutDetaching
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @return mixed
     */
     public function syncWithoutDetaching($id, $relation, $attributes);

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function all($columns = ['*']);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function paginate($limit = null, $columns = ['*']);

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function simplePaginate($limit = null, $columns = ['*']);

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function find($id, $columns = ['*']);

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function findByField($field, $value, $columns = ['*']);

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * Find data by excluding multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']);

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function create(array $attributes);

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id);

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function delete($id);

    /**
     * Delete multiple entities by given criteria.
     *
     * @param array $where
     *
     * @return int
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function deleteWhere(array $where);
    
    /**
     * Order collection by a given column
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * Check if entity has relation
     *
     * @param string $relation
     *
     * @return $this
     */
    public function has($relation);

    /**
     * Load relations
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations);

    /**
     * Load relation with closure
     *
     * @param string $relation
     * @param closure $closure
     *
     * @return $this
     */
    public function whereHas($relation, $closure);

    /**
     * Add subselect queries to count the relations.
     *
     * @param  mixed $relations
     * @return $this
     */
    public function withCount($relations);

    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hidden(array $fields);

    /**
     * Set visible fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function visible(array $fields);

    /**
     * Query Scope
     *
     * @param \Closure $scope
     *
     * @return $this
     */
    public function scopeQuery(\Closure $scope);

    /**
     * Reset Query Scope
     *
     * @return $this
     */
    public function resetScope();

    /**
     * Get Searchable Fields
     *
     * @return array
     */
    public function getFieldsSearchable();

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function first($columns = ['*']);

    /**
     * Retrieve first data of repository, or return new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function firstOrNew(array $attributes = []);

    /**
     * Retrieve first data of repository, or create new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     * @throws \AcDevelopers\Repository\Exceptions\RepositoryException
     */
    public function firstOrCreate(array $attributes = []);
}