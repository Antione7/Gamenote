<?php

namespace Application\Controllers;

use \Library\Core\Controller;
use \Application\Models\User as ModelUser;
use \Application\Models\Game as ModelGame;

class Index extends Controller {

    private $mu;
    private $mg;

    public function __construct() {
        parent::__construct();
        $this->mu = new ModelUser('localhost');
        $this->mg = new ModelGame('localhost');
    }

    public function indexAction() {
        $error = $this->mu->getErrorData($_POST);

        if (!empty($_POST) && empty($error)) {
            $user = $this->mu->findForAuth($this->mu->cleanData($_POST));
            if (!empty($user)) {
                if (password_verify($_POST['password'], $user->password)) {
                    unset($user->password);
                    $_SESSION['user'] = $user;
                    //header("location: ".LINK_WEB);
                    //exit();
                } else {
                    array_push($error, "email or password not valid");
                }
            } else {
                array_push($error, "email or password not valid");
            }
        }

        $games = $this->mg->fetchAll();

        $this->setDataView(array(
            "errors" => $error,
            "games" => $games
        ));
    }

}
