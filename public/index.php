<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 19/09/17
 * Time: 15:46
 */

require __DIR__.'/../app/bootstrap.php';

$router = new \Lib\Router();

$router->dispatch($_SERVER['REQUEST_URI']);
