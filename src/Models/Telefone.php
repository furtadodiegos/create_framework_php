<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 20/09/17
 * Time: 19:32
 */

namespace Models;


use Lib\Model;

class Telefone extends Model
{

    /**
     * @var \PDO
     */
    protected $pdo;

    private $id;

    private $cod_contato;

    private $num_celular;

    private $num_residencial;

    public function __construct()
    {
        $this->pdo = static::getPDO();
    }

    public function getOneBy($filter, $param)
    {
        $consulta = $this->pdo->prepare("SELECT * FROM telefone where $filter = :contato;");
        $consulta->bindParam(':contato', $param, \PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetch(\PDO::FETCH_ASSOC);
    }

    public function persist(array $params, $id = null)
    {
        $fields = $this->prepareData($params);

        $sql = ($id != null) ? $this->updateQuery($fields, $id) : $this->saveQuery($fields);

        $transaction = $this->pdo->prepare($sql);

        foreach ($params as $k => $v)
        {
            $transaction->bindValue(':' . $k, $v);
        }

        return $this->execute($this->pdo, $transaction);
    }

    private function prepareData($params)
    {
        $fields = array();
        $binds = array();

        $fields['fields'] = implode(',', array_keys($params));

        foreach ($params as $key => $value) {
            $this->$key = $value;

            $binds[] = ':'.$key;
        }

        $fields['binds'] = implode(',', $binds);

        return $fields;
    }

    private function saveQuery($fields)
    {
        return "INSERT INTO telefone (".$fields['fields'].") VALUES (".$fields['binds'].")";
    }

    private function updateQuery($fields, $id)
    {
        $keys = explode(',', $fields['fields']);
        $values = explode(',', $fields['binds']);

        $sql = "UPDATE telefone set ";
        foreach ($keys as $k => $v) {
            $sql .= $v.' = '.$values[$k].',';
        }
        $sql = substr_replace($sql, " ", -1);
        $sql .= "where cod_contato = $id";

        return $sql;
    }
}