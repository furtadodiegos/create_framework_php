<?php

namespace Lib;


use Lib\Model;

/**
 * Base controller
 *
 * PHP version 5.4
 */
abstract class Controller
{

    /**
     * @param $name
     * @param $args
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        $name = explode('/', $name, 2);
        $args = isset($name[1]) ? ['param' => $name[1]] : $args;

        $method = $name[0] . 'Action';

        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], $args);
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }
}
