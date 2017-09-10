<?php

namespace Application\Models;

use \Library\Core\Model;
use \PDO;

class Game extends Model {

    protected $table = 'games';
    protected $primary = 'id';
    protected $structure = array(
        "name" => array(
            "type" => "string"
        ),
        "platform" => array(
            "type" => "string"
        ),
        "genre" => array()
    );

    public function __construct($connexionName) {
        parent::__construct($connexionName);
    }

    public function attributeGenre(array $data): bool{
        $sql = $this->database->prepare("INSERT INTO genreattribution (`id_genre`,`id_games`) VALUES (:id_genre,:id_games)");
        return $sql->execute($data);
    }
    
    public function getGenreList(): array {
        $sql = $this->database->prepare("SELECT id, name FROM genre");
        $sql->execute();
        
        return $sql->fetchAll();
    }
}
