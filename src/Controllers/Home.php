<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 19/09/17
 * Time: 23:09
 */

namespace src\Controllers;


use Lib\Controller;
use Lib\View;

class Home extends Controller
{

    public function indexAction()
    {
        View::render('Home/index.php', []);
    }
}