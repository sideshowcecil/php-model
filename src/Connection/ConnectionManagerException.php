<?php
namespace sideshow_bob\Model\Connection;

/**
 * Exception indicating problems with the ConnectionManager.
 * @package sideshow_bob\Model
 */
class ConnectionManagerException extends \Exception
{
    /**
     * @inheritdoc
     */
    public function __construct($message, \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
