<?php

namespace Application\Controllers;

use \Library\Core\Controller;
use \Application\Models\User as ModelUser;

class User extends Controller {

    private $mu;


    public function __construct(){
        parent::__construct();
        $this->mu = new ModelUser('localhost');
    }



    public function indexAction(){
        if(!isset($_SESSION['user'])){
            header("location: ".LINK_WEB."user/login");
            exit();
        }
        header("location: ".LINK_WEB);
        exit();
    }



    public function logoutAction(){
        session_unset();
        header("location: ".LINK_WEB);
        exit();
    }



    public function loginAction(){

        $error = $this->mu->getErrorData($_POST);

        if(!empty($_POST) && empty($error)){

            $user = $this->mu->findForAuth($this->mu->cleanData($_POST));
            if(password_verify($_POST['password'], $user['password'])){
                $_SESSION['user'] =  $user;
                header("location: ".LINK_WEB);
                exit();
            } else {
                array_push($error, "mail or password not valid");
            }

        }

        $this->setDataView(array("errors"=>$error));
    }



    public function registerAction() {

        $error = $this->mu->getErrorData($_POST);

        if(!empty($_POST)){

            if(!isset($_POST['password'],$_POST['passwordc']) || $_POST['password'] !== $_POST['passwordc']){
                array_push($error, "Password confirm is not valid");
            }

            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if(empty($error)){
                if($this->mu->insert($this->mu->cleanData($_POST))){
                    header("location: ".LINK_WEB);
                    exit();
                } else {
                    array_push($error, "Email already exists");
                }
            }
        }

        $this->setDataView(array("errors"=>$error));
    }



    public function updateAction($id = null) {

    }



    public function deleteAction($id = null) {

    }
}

