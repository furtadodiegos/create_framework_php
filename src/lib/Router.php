<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 19/09/17
 * Time: 20:59
 */

namespace Lib;


class Router
{

    /**
     * @var array
     */
    protected $params = [];

    public function generateParams($route)
    {
        $parts = explode('/', $route, 3);

        $this->params['controller'] = ($parts[1] == '') ? 'home' : $parts[1];
        $this->params['action'] = (isset($parts[2]) && $parts[2] != '') ? $parts[2] : 'index';
    }


    public function dispatch($url)
    {
        $this->generateParams($url);

        $controller = $this->params['controller'];
        $controller = $this->treatmentHyphen($controller);
        $controller = $this->getNamespace() . $controller;

        if (class_exists($controller)) {
            $controller_object = new $controller($this->params);

            $action = $this->params['action'];
            $action = $this->treatmentCase($action);

            if (is_callable([$controller_object, $action])) {
                $controller_object->$action();
            } else {
                throw new \Exception("Method $action (in controller $controller) not found");
            }
        } else {
            throw new \Exception("Controller class $controller not found");
        }
    }

    /**
     * Remove os " - "
     *
     * @param $string
     * @return mixed
     */
    protected function treatmentHyphen($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Faz o tratamento do hífen e coloca a primeira letra como maiúscula
     *
     * @param $string
     * @return string
     */
    protected function treatmentCase($string)
    {
        return lcfirst($this->treatmentHyphen($string));
    }

    /**
     * Retorna o caminho base para o arquivo
     *
     * @return string
     */
    protected function getNamespace()
    {
        return 'src\Controllers\\';
    }
}