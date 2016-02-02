<?php
namespace sideshow_bob\Model;

/**
 * A basic query interface inspired by the eloquent query builder.
 * @package sideshow_bob\Model
 */
interface Query
{
    /**
     * Execute the query.
     * @return Model[]
     */
    public function get();

    /**
     * Execute the query and get the first result.
     * @return Model
     * @throws RecordNotFoundException
     */
    public function first();

    /**
     * Force the query to only return distinct results.
     * @return Query
     * @throws QueryException
     */
    public function distinct();

    /**
     * Set the "model" which the query is targeting.
     * @param string|Model $model
     * @return Query
     * @throws QueryException
     */
    public function from($model);

    /**
     * Set the "limit" value of the query.
     * @param int $count
     * @return Query
     * @throws QueryException
     */
    public function limit($count);

    /**
     * Set the "offset" value of the query.
     * @param int $count
     * @return Query
     * @throws QueryException
     */
    public function offset($count);

    /**
     * Add an "order by" clause to the query.
     * @param string $attribute
     * @param string $direction
     * @return Query
     * @throws QueryException
     */
    public function orderBy($attribute, $direction = "asc");

    /**
     * Add a basic where clause to the query.
     * @param string|array|\Closure $attribute
     * @param string $operator
     * @param mixed $value
     * @param string $connector
     * @return Query
     * @throws QueryException
     */
    public function where($attribute, $operator = null, $value = null, $connector = "and");
}
