<?php
namespace sideshow_bob\Model;

/**
 * Class QueryException
 * @package sideshow_bob\Model
 */
class QueryException extends \Exception
{
    /**
     * @inheritdoc
     */
    public function __construct($message, \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
