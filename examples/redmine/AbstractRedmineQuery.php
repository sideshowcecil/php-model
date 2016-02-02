<?php
namespace sideshow_bob\examples\redmine;

use Redmine\Client;
use sideshow_bob\Model\Model;
use sideshow_bob\Model\Query;
use sideshow_bob\Model\QueryException;
use sideshow_bob\Model\RecordNotFoundException;
use Stringy\StaticStringy;

abstract class AbstractRedmineQuery implements Query
{
    /**
     * Allowed operators.
     * @var array
     */
    protected static $SUPPORTED_OPERATORS = ["=", "<", ">", "<=", ">=", "><"];

    protected $client;
    protected $limits;
    protected $conditions;

    /**
     * Constructor.
     * @param Client $client the redmine client
     * @param array $conditions [optional] conditions
     * @param array $limits [optional] limitations
     */
    public function __construct(Client $client, array $conditions = [], array $limits = [])
    {
        $this->client = $client;
        $this->conditions = $conditions;
        $this->limits = $limits;
    }

    /**
     * @inheritdoc
     */
    public function first()
    {
        $models = $this->get();
        if (empty($models)) {
            throw new RecordNotFoundException("The query returned no results");
        }
        return current($models);
    }

    /**
     * @inheritdoc
     */
    public function distinct()
    {
        throw new QueryException("Method not supported");
    }

    /**
     * @inheritdoc
     */
    public function from($model)
    {
        throw new QueryException("Method not supported");
    }

    /**
     * @inheritdoc
     */
    public function limit($count)
    {
        return new static(
            $this->client,
            $this->conditions,
            array_merge(
                $this->limits,
                ["limit" => $count]
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function offset($count)
    {
        return new static(
            $this->client,
            $this->conditions,
            array_merge(
                $this->limits,
                ["offset" => $count]
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function orderBy($attribute, $direction = "asc")
    {
        $direction = strtolower($direction);
        // validate the direction
        if (!in_array($direction, ["asc", "desc"])) {
            throw new QueryException("Invalid direction given");
        }
        // return a new query instance
        return new static(
            $this->client,
            $this->conditions,
            array_merge(
                $this->limits,
                ["sort" => "${attribute}:${direction}"]
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function where($attribute, $operator = null, $value = null, $connector = "and")
    {
        // here we ignore the $connector parameter as it is not supported by the redmine api
        // validate the attribute
        if (!is_string($attribute)) {
            throw new QueryException("We only support string as the attribute name");
        }
        // validate the operator
        if ($operator !== null && !in_array($operator, static::$SUPPORTED_OPERATORS, true)) {
            throw new QueryException("Invalid operator given");
        }
        if ($operator === "=") {
            // if an equals is used we set the operator to the empty string
            $operator = "";
        }
        // validate the value
        if (empty($value)) {
            throw new QueryException("No value given");
        }
        // handle relations
        if ($value instanceof Model) {
            // handle relations in a custom way
            if (!StaticStringy::endsWith($attribute, "_id")) {
                $attribute .= "_id";
            }
            $value = $value->id();
        }
        // return a new query instance
        return new static(
            $this->client,
            array_merge(
                $this->conditions,
                ["$attribute" => "${operator}${value}"]
            ),
            $this->limits
        );
    }

    /**
     * Build the parameters array which can directly be used in the redmine query.
     * @return array
     */
    protected function buildParams()
    {
        return array_merge(
            $this->conditions,
            $this->limits
        );
    }
}
