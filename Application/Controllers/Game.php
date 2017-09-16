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
    
    public function indexAction(){
        $games = $this->mg->getCriticsByUserId();

        $this->setDataView(array(
            "games" => $games
        ));
    }

    public function createAction() {
        $error = $this->mg->getErrorData($_POST);

        if (!empty($_POST) && empty($error)) {
            $genres;
            foreach ($_POST['genre'] as $genre) {
                if (!is_array($genre) && intval($genre) > 0) {
                    $genres[] = intval($genre);
                }
            }
            unset($_POST['genre']);
            $_POST['id_platforms'] = is_array($_POST['id_platforms']) ? 0 : intval($_POST['id_platforms']);
            if ($_POST['id_platforms'] === 0) {
                array_push($error, "An error occurs");
            }

            if (empty($error)) {
                $id_games = $this->mg->insert($this->mg->cleanData($_POST));
                if ($id_games > 0) {
                    if ($this->mg->attributeGenre($id_games, $genres)) {
                        header("location: " . LINK_WEB . "critic/create");
                        exit();
                    } else {
                        array_push($error, "An error occurs");
                    }
                } else {
                    array_push($error, "An error occurs");
                }
            }
        }

        $genres = $this->mg->getGenreList();
        $platforms = $this->mg->getPlatformList();

        $this->setDataView(array(
            "errors" => $error,
            "genres" => $genres,
            "platforms" => $platforms
        ));
    }

    public function readAction(int $id) {
        
    }

    public function updateAction(array $data) {
        
    }

    public function deleteAction(int $id) {
        
    }

}
