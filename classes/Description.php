<?php

/**
 * Created by PhpStorm.
 * User: Base
 * Date: 16.07.2017
 * Time: 20:45
 */
class Description
{
    public $destination;
    public $Error;

    public function __construct($obj)
    {
        $this->destination = $obj;
    }

    public function __toString()
    {
        return (string)$this->destination;
    }

}