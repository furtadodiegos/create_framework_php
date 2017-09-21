<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 20/09/17
 * Time: 13:07
 */

namespace Models;


use Lib\Model;

class Contato extends Model
{

    /**
     * @var \PDO
     */
    protected $pdo;

    private $id;

    private $str_nome;

    public function __construct()
    {
        $this->pdo = static::getPDO();
    }


    public function getOne($id)
    {
        $consulta = $this->pdo->prepare("SELECT * FROM contato where id = :contato;");
        $consulta->bindParam(':contato', $id, \PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query('
            SELECT contato.*, telefone.num_celular, telefone.num_residencial
                FROM contato
                JOIN telefone ON (telefone.cod_contato = contato.id)
');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        return "INSERT INTO contato (".$fields['fields'].") VALUES (".$fields['binds'].")";
    }

    private function updateQuery($fields, $id)
    {
        return "UPDATE contato set ".$fields['fields']." = ".$fields['binds']." where id = $id";
    }
}