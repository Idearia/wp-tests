<?php
namespace Idearia;

/**
 * Example class to be tested with PHPUnit
 */
class SimpleClass
{
    protected string $message;

    public function setMessage( $message )
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}