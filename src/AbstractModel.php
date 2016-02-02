<?php
namespace sideshow_bob\Model;

/**
 * An abstract class providing some utility methods for a record.
 * @package sideshow_bob\Model
 */
abstract class AbstractModel implements Model
{
    private $new;
    private $dirty;

    /**
     * AbstractModel constructor.
     * @param bool $new [optional]
     */
    public function __construct($new = true)
    {
        $this->setPersisted($new);
        $this->resetDirty();
    }

    /**
     * Return if the model is new.
     * @return bool
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Set the persistence status of the model.
     * @param bool $status [optional]
     */
    protected function setPersisted($status = false)
    {
        $this->new = $status;
    }

    /**
     * Return if the model is dirty.
     * @return bool
     */
    public function isDirty()
    {
        return !empty($this->dirty);
    }

    /**
     * Reset the model's dirty attributes.
     */
    protected function resetDirty()
    {
        $this->dirty = [];
    }

    /**
     * Flag an attribute as dirty.
     * @param string $name attribute name
     */
    protected function flagDirty($name)
    {
        $this->dirty[$name] = true;
    }

    /**
     * Get a list of all dirty attributes.
     * @return array
     */
    protected function dirtyAttributes()
    {
        return array_keys($this->dirty);
    }

    /**
     * Get a hash of all dirty attributes incl. values.
     * @return array
     */
    protected function dirtyAttributeValues()
    {
        $params = [];
        foreach ($this->dirtyAttributes() as $attribute) {
            $params[$attribute] = $this->$attribute;
        }
        return $params;
    }

    /**
     * Map the setting of non-existing fields to a mutator when possible, otherwise use the matching field.
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        // validate that the property exists
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Setting the field '$name' is not valid for this entity.");
        }
        // flag the attribute as dirty
        $this->flagDirty($name);
        // set the value
        $mutator = "set" . ucfirst($name);
        if (method_exists($this, $mutator) && is_callable([$this, $mutator])) {
            $this->$mutator($value);
        } else {
            $this->$name = $value;
        }
    }

    /**
     * Map the getting of non-existing properties to an accessor when possible, otherwise use the matching field.
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        // validate that the property exists
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Getting the field '$name' is not valid for this entity.");
        }
        // return the value
        $accessor = "get" . ucfirst($name);
        return (method_exists($this, $accessor) && is_callable([$this, $accessor]))
            ? $this->$accessor()
            : $this->$name;
    }
}
