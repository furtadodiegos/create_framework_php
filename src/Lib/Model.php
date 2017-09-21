<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 20/09/17
 * Time: 11:18
 */

namespace Lib;


use Config;

class Model
{
    /**
     * Conexao via PDO com o banco de dados
     *
     * @return \PDO
     */
    protected static function getPDO()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new \PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    protected function execute(\PDO $pdo, $transaction)
    {
        try {
            $pdo->beginTransaction();

            $transaction->execute();

            $lastId = $pdo->lastInsertId();

            $pdo->commit();

            return $lastId;
        } catch (\PDOException $e) {
            $pdo->rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }
}