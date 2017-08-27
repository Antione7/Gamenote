<?php

namespace Application\Models;

use \Library\Core\Model;

class User extends Model {

    protected $table = 'users';
    protected $primary = 'id';
    protected $structure = array(
        "mail" => array(
            "type" => "mail"
        ),
        "password" => array(
            "type" => "string",
            "minLength" => "5",
            "maxLength" => "15"
        )
    );

    public function __construct($connexionName) {
        parent::__construct($connexionName);
    }

    public function findForAuth($data) {
        $sql = $this->database->prepare("SELECT `id`, `mail`, `update` FROM `{$this->table}` WHERE `mail`=:mail");
        $sql->execute($data);
        $result = $sql->fetchAll();

        if (count($result) === 1) {
            return $result[0];
        }

        return false;
    }

}
