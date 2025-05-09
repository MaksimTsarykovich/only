<?php

namespace Src\Helpers;

class Dump
{
    /**
     * Simple function to dump variables for debugging
     *
     * @param mixed $var The variable to dump
     * @param bool $die Whether to stop execution after dumping
     * @return void
     */
static function dump($var, $die = false)
    {

    }

    /**
     * Shorthand function to dump and die
     *
     * @param mixed $var The variable to dump
     * @return void
     */
    static function dd($var)
    {
        dump($var, true);
    }

}