<?php

namespace Library\Template;

class Helpers {

    public function foundInputValue($name, $src=null){
        if(!is_null($src) && empty($_POST)){
            return isset($src->$name)?$src->$name:'';
        }
        return isset($_POST[$name])?$_POST[$name]:'';
    }

    public function isAuthenticated(){
        return isset($_SESSION['user']);
    }

}


