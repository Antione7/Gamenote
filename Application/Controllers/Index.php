<?php

namespace Application\Controllers;

use \Library\Core\Controller;
use \Application\Models\User as ModelUser;

class Index extends Controller {
    
    private $mu;

    public function __construct(){
        parent::__construct();
         $this->mu = new ModelUser('localhost');
    }

    public function indexAction(){
        $error = $this->mu->getErrorData($_POST);

        if(!empty($_POST) && empty($error)){
            $user = $this->mu->findForAuth($this->mu->cleanData($_POST));
            if(password_verify($_POST['password'], $user->password)){
                unset($user->password);
                $_SESSION['user'] =  $user;
                //header("location: ".LINK_WEB);
                //exit();
            } else {
                array_push($error, "email or password not valid");
            }

        }

        $this->setDataView(array("errors"=>$error));
    }

    public function testAction(){

    }
}