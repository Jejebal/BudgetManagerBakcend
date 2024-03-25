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

namespace Projet\Budgetmanager\api\php\model;

use PDOException;
use Projet\Budgetmanager\api\php\model\BaseModel as BaseModel;

use Projet\Budgetmanager\api\php\model\Database as Database;

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

    public static function selectAllCategorie() : array | false | PDOException {

        $query = "SELECT * FROM `Categorie`;";

        try{

            $statement = DataBase::getDB()->run($query);
            $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
            return $statement->fetchAll();

        }
        catch(PDOException $exception){

            return $exception;

        }

    }

    public static function selectCategorieById($id) : CategorieModel | false | PDOException {

        $query = "SELECT *
        FROM `Categorie`
        WHERE `Categorie`.`id_categorie` = :idCategorie;";

        $param = [

            ":idCategorie" => $id

        ];

        try {

            $statement = DataBase::getDB()->run($query, $param);
            $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
            return $statement->fetch();

        }
        catch(PDOException $exception){

            return $exception;

        }

    }
}