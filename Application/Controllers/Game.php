<?php

namespace Application\Controllers;

use \Library\Core\Controller;
use \Application\Models\Game as ModelGame;

class Game extends Controller {

    private $mg;

    public function __construct() {
        parent::__construct();
        $this->mg = new ModelGame('localhost');
    }

    public function createAction() {
        $error = $this->mg->getErrorData($_POST);

        if (!empty($_POST) && empty($error)) {
            $id_genre = $_POST['genre'];
            unset($_POST['genre']);
            $id_games = $this->mg->insert($this->mg->cleanData($_POST));
            if (is_int($id_games) && is_int($id_genre)) {
                $data = array(
                    "id_genre" => $id_genre,
                    "id_games" => $id_games
                );
                if ($this->mg->attributeGenre($id)) {
                    header("location: " . LINK_WEB);
                    exit();
                }
            } else {
                array_push($error, "Email already exists");
            }
        }

        $genres = $this->mg->getGenreList();

        $this->setDataView(array(
            "errors" => $error,
            "genres" => $genres
        ));
    }

    public function readAction(int $id) {
        
    }

    public function updateAction(array $data) {
        
    }

    public function deleteAction(int $id) {
        
    }

}
