<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : DepenseModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\model;

use Projet\Budgetmanager\model\BaseModel as BaseModel;
use Projet\Budgetmanager\model\Database;

class DepenseModel extends BaseModel {

    protected $map = [

        "id_depense" => "idDepense",
        "nom_depense" => "nomDepense",
        "montant" => "montant",
        "date" => "date",
        "id_categorie" => "idCategorie"
    ];

    public int $idDepense;

    public string $nomDepense;

    public int $montant;

    public string $date;

    public int $idCategorie;

    public function __construct(array $init = [])
    {

        $this->idDepense = $init["id_depense"] ?? -1;

        $this->nomDepense = $init["nom_depense"] ?? "";

        $this->montant = $init["montant"] ?? -1;

        $this->date = $init["date"] ?? "";

        $this->idCategorie = $init["id_categorie"] ?? -1;
        
    }

    public static function setDepense(){

        $query = "INSERT INTO `Depense`
        (`nom_depense`, `montant`, `date`, `id_categorie`)
        VALUES(:nomDepense, :montant, :date, :idCategorie);";

        $param = [

            ":nomDepense" => $nom,
            ":montant" => $montant,
            ":date" => $date,
            ":idCategorie" => $idCategorie

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }

    public static function getDepense($id){

        $query = "SELECT *
        FROM `Depense`
        WHERE `Depense`.`id_depense` = :idDepense;";

        $param = [

            ":idDepense" => $id

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }

    public static function updateDepense($id, $nom, $montant, $date, $idCategorie){

        $query = "UPDATE Depense
        SET `nom_depense` = :nomDepense, `montant` = :montant, `date`= :date, `id_categorie` = :idCategorie
        WHERE `id_depense` = :idDepense;";

        $param = [

            ":idDepense" => $id,
            ":nomDepense" => $nom,
            ":montant" => $montant,
            ":date" => $date,
            ":idCategorie" => $idCategorie

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }

    public static function deleteDepense($id){

        $query = "DELETE FROM `Depense`
        WHERE `Depense`.`id_depense` = :idDepense;";

        $param = [

            ":idDepense" => $id

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }
}