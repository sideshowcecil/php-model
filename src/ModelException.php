<?php
namespace sideshow_bob\Model;

/**
 * The default exception used by this library.
 * @package sideshow_bob\Model
 */
class ModelException extends \Exception
{
    /**
     * @inheritdoc
     */
    public function __construct($message = "", \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
