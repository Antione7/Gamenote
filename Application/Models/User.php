<?php

namespace Application\Models;

use \Library\Core\Model;

class User extends Model {

    protected $table = 'users';
    protected $primary = 'id';
    protected $structure = array(
        "email" => array(
            "type" => "email"
        ),
        "password" => array(
            "type" => "string",
            "minLength" => "5",
            "maxLength" => "15"
        ),
        "pseudo" => array(
            "type" => "string",
            "minLength" => "3",
            "maxLength" => "15"
        ),
        "lastName" => array(
            "type" => "string"
        ),
        "firstName" => array(
            "type" => "string"
        )
    );

    public function __construct($connexionName) {
        parent::__construct($connexionName);
    }

    public function findForAuth($data) {
        $sql = $this->database->prepare("SELECT `id`, `email`, `update` FROM `{$this->table}` WHERE `email`=:email");
        $sql->execute($data);
        $result = $sql->fetchAll();

        if (count($result) === 1) {
            return $result[0];
        }

        return false;
    }

}
