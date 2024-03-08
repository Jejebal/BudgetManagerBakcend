<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : CategorieModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\model;

use Projet\Budgetmanager\model\BaseModel as BaseModel;

use Projet\Budgetmanager\model\Database as Database;

class CategorieModel extends BaseModel {

    protected $map = [

        "id_categorie" => "idCategorie",
        "nom_categorie" => "nomCategorie"

    ];

    public int $idCategorie;

    public string $nomCategorie;

    public function __construct(array $init = [])
    {

        $this->idCategorie = $init["id_categorie"] ?? -1;

        $this->nomCategorie = $init["nom_categorie"] ?? "";
        
    }

    public function setCategorie(){

        $query = "INSERT INTO `Categorie`
        (`nom_categorie`)
        VALUES(:nomCategorie);";

        $param = [

            ":nomCategorie" => $this->nomCategorie

        ];

        $statement = DataBase::getDB()->run($query, $param);

    }

    public static function getCategorie($id){

        $query = "SELECT *
        FROM `Categorie`
        WHERE `Categorie`.`id_categorie` = :idCategorie;";

        $param = [

            ":idCategorie" => $id

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }

    public static function updateCategorie($id, $nom){

        $query = "UPDATE `Categorie`
        SET `nom_categorie` = :nomCategorie
        WHERE `id_categorie` = :idCategorie;";

        $param = [

            ":idCategorie" => $id,
            ":nomCategorie" => $nom

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }

    public static function deleteCategorie($id){

        $query = "DELETE FROM `Categorie`
        WHERE `Categorie`.`id_categorie` = :idCategorie;";

        $param = [

            ":idCategorie" => $id

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }
}