<?php

namespace Application\Models;

use \Library\Core\Model;
use \PDO;

class Critic extends Model {

    protected $table = 'critics';
    protected $structure = array(
        "rating" => array(
            "type" => "int",
            "max" => 5
        ),
        "note" => array(
            "type" => "string"
        )
    );

    public function __construct($connexionName) {
        parent::__construct($connexionName);
    }

    public function getCriteriaList(): array {
        $sql = $this->database->prepare("SELECT id, name FROM criterias");
        $sql->execute();

        return $sql->fetchAll();
    }
}
