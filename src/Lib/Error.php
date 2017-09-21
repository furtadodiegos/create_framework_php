<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 20/09/17
 * Time: 09:52
 */

namespace Lib;


use Config;

class Error
{
    /**
     * Transforma o erro em exceção
     *
     * @param $level
     * @param $message
     * @param $file
     * @param $line
     * @throws \ErrorException
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Tratamento das execptions.
     *
     * @param $exception
     * @throws \Exception
     */
    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }

        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            echo "<h1>Erro encontrado</h1>";
            echo "<p>Exception: '" . get_class($exception) . "'</p>";
            echo "<p>Mensagem: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {
            $log = dirname(__DIR__) . '/../logs/' . date('Y-m-d') . '.txt';

            ini_set('error_log', $log);

            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();
            $message .= "\n\n";

            error_log($message);

            View::render("Error/$code.html");
        }
    }
}