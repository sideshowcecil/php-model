<?php
namespace sideshow_bob\Model;

/**
 * A general model interface.
 * @package sideshow_bob\Model
 */
interface Model
{
    // begin static methods

    /**
     * Find a record with the given identifier.
     * @param mixed $id
     * @return static
     * @throws RecordNotFoundException
     */
    public static function find($id);

    /**
     * Query the model.
     * @return Query
     */
    public static function query();

    /**
     * Query the model according the the given condition.
     * @param string|array|\Closure $attribute
     * @param string $operator
     * @param mixed $value
     * @param string $connector
     * @return static[]
     */
    public static function where($attribute, $operator = null, $value = null, $connector = "and");

    /**
     * Create an instance of the model based on the given parameters.
     * This helper function allows external classes to easily create model instances.<br/>
     * <b>Note:</b> This method does not specify any parameters as they may vary between models.
     * @return static
     */
    public static function factory();

    // end static methods

    /**
     * Get the identifier of the model record.
     * @return mixed
     */
    public function id();

    /**
     * Save the model record.
     * @return void
     * @throws RecordPersistenceException
     */
    public function save();

    /**
     * Delete the model record.
     * @return void
     * @throws RecordPersistenceException
     */
    public function delete();
}
