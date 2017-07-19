<?php

/**
 * Created by PhpStorm.
 * User: Base
 * Date: 16.07.2017
 * Time: 19:39
 */
spl_autoload_register(function ($class) {
    include_once 'classes/' . $class . '.php';
});

class Basis
{
    public $TableBasic;


    // принимает worksheet Ecxel document
    public function __construct($list)
    {
        intit($list);
    }

    private function init($list){
        foreach ($list as $row){

        }
    }
}