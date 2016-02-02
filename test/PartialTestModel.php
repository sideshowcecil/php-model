<?php
namespace sideshow_bob\Model;

/**
 * A model implementation for testing the AbstractModel methods.
 * @package sideshow_bob\Model
 * @property mixed $x
 * @property mixed $y
 * @property mixed $z
 */
class PartialTestModel extends AbstractModel
{
    private $x;
    protected $y;
    public $z;

    /**
     * Getter for X.
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Setter for X.
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @inheritdoc
     */
    public static function find($id)
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * @inheritdoc
     */
    public static function query()
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * @inheritdoc
     */
    public static function where($attribute, $operator = null, $value = null, $connector = "and")
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * @inheritdoc
     */
    public static function factory(/* ... */)
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * @inheritdoc
     */
    public function id()
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        throw new \RuntimeException("Not implemented");
    }
}
