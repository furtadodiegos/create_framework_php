<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 20/09/17
 * Time: 09:37
 */

namespace Lib;


class View
{

    /**
     * Funcao para renderizar a view da action
     *
     * @param $view
     * @param array $args
     * @throws \Exception
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../src/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }
}