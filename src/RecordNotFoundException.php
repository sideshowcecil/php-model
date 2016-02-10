<?php
namespace sideshow_bob\Model;

/**
 * Exception marking a not found record.
 * @package sideshow_bob\Model
 */
class RecordNotFoundException extends \Exception
{
    /**
     * @inheritdoc
     */
    public function __construct($message = "", \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
