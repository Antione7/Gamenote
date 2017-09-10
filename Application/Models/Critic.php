<?php

namespace Application\Models;

use \Library\Core\Model;
use \PDO;

class Critic extends Model {

    protected $table = 'games';
    protected $primary = 'id';
    protected $structure = array(
        "name" => array(
            "type" => "string"
        ),
        "id_platforms" => array(
            "type" => "int"
        )
    );

    public function __construct($connexionName) {
        parent::__construct($connexionName);
    }

    public function attributeGenre(int $id_games, array $genres): bool {
        $result;
        foreach ($genres as $genre) {
            $sql = $this->database->prepare("INSERT INTO genreattribution (`id_genre`,`id_games`) VALUES (:id_genre,:id_games)");
            $sql->bindParam(':id_genre', $genre, PDO::PARAM_INT);
            $sql->bindParam(':id_games', $id_games, PDO::PARAM_INT);
            $result = $sql->execute();
            if(!$result){
                return false;
            }
        }
        return $result;
    }

    public function getGenreList(): array {
        $sql = $this->database->prepare("SELECT id, name FROM genre");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getPlatformList(): array {
        $sql = $this->database->prepare("SELECT id, name FROM platforms");
        $sql->execute();

        return $sql->fetchAll();
    }

}
