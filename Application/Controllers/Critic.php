<?php

namespace Application\Controllers;

use \Library\Core\Controller;
use \Application\Models\Critic as ModelCritic;

class Critic extends Controller {

    private $mc;

    public function __construct() {
        parent::__construct();
        $this->mc = new ModelCritic('localhost');
    }
    
    public function indexAction($id_games = null, $id_criterias = null){
        if (is_null($id_games) || empty($id_games)) {
            header("location: " . LINK_WEB);
            exit();
        }
        
        $criterias = $this->mc->getCriteriaList();
        if(is_null($id_criterias) || empty($id_criterias)){
            $id_criterias = $criterias[0]->id;
        }
        $critics = $this->mc->getCriticList($id_games, $id_criterias);
        
        $this->setDataView(array(
            "criterias" => $criterias,
            "critics" => $critics,
            "param1" => $id_games,
            "param2" => $id_criterias
        ));
    }

    public function createAction($id = null) {
        if (is_null($id) || empty($id)) {
            header("location: " . LINK_WEB);
            exit();
        }
        $error = array();

        if (!empty($_POST)) {
            $id_users = $_SESSION['user']->id;
            $c = count($_POST['criteria']);
            $result = false;
            for ($i = 0; $i < $c; $i++) {
                $data['rating'] = intval($_POST['rating'][$i]);
                $data['note'] = $_POST['note'][$i];
                $data['id_users'] = $id_users;
                $data['id_games'] = intval($id);
                $data['id_criterias'] = intval($_POST['criteria'][$i]);
                $error = $this->mc->getErrorData($data);

                if (empty($error)) {
                    if ($this->mc->insert($data) === 1) {
                        $result = true;
                    } else {
                        array_push($error, "An error occurs");
                    }
                }
            }

            if ($result) {
                header("location: " . LINK_WEB);
                exit();
            }
        }

        $criterias = $this->mc->getCriteriaList();

        $this->setDataView(array(
            "errors" => $error,
            "criterias" => $criterias
        ));
    }

    public function readAction(int $id) {
        
    }

    public function updateAction(array $data) {
        
    }

    public function deleteAction(int $id) {
        
    }

}
