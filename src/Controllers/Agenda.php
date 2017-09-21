<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 19/09/17
 * Time: 23:39
 */

namespace src\Controllers;


use Lib\Controller;
use Lib\View;
use Models\Contato;
use Models\Telefone;

class Agenda extends Controller
{

    /**
     * @var Contato
     */
    protected $contato;

    /**
     * @var Telefone
     */
    protected $telefone;

    public function __construct()
    {
        $this->contato = new Contato();
        $this->telefone = new Telefone();
    }

    public function indexAction()
    {
        View::render('Agenda/index.php', [
            'params' => $this->contato->getAll()
        ]);
    }

    public function contatoAction()
    {
        $data = array(
            'contato' => $this->contato->getOne($_POST['id']),
            'telefone' => $this->telefone->getOneBy('cod_contato', $_POST['id'])
        );

        echo json_encode($data, true);
    }

    public function addAction($args = null)
    {
        if ($args) {
            $args = array(
                'contato' => $this->contato->getOne($args),
                'telefone' => $this->telefone->getOneBy('cod_contato', $args)
            );
        }

        View::render('Agenda/add.php', [
            'params' => $args
        ]);
    }

    public function insertAction($id = null)
    {
        if ($this->isValid($_POST)) {

            $dataContato = array(
                'str_nome' => $_POST['str_nome']
            );

            $contato = $this->contato->persist($dataContato, $id);

            if (is_numeric($contato)) {
                $dataTelefone = array(
                    'cod_contato' => ($id != null) ? $id : $contato,
                    'num_celular' => $_POST['num_celular'],
                    'num_residencial' => $_POST['num_residencial']
                );

                $telefone = $this->telefone->persist($dataTelefone, $id);

                if (is_numeric($telefone)) {
                    echo json_encode(['contato' => $contato, 'status' => 200], true);
                }
            }
        }
    }

    private function isValid($params)
    {
        if (empty($params) || $params['str_nome'] === '' || $params['num_celular'] === '') {
            throw new \Exception('Preencha os campos obrigatorios.', 500);
        }

        if (!preg_match("/^[a-zA-Z -]+$/", $params['str_nome'])) {
            throw new \Exception('O nome deve conter apenas letras.', 500);
        }

        return true;
    }
}