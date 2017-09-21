<?php

require __DIR__.'/../vendor/autoload.php';

/**
 * Mostra todos os erros!
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_error_handler('Lib\Error::errorHandler');
set_exception_handler('Lib\Error::exceptionHandler');
