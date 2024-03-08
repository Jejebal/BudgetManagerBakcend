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

use PDOException;
use Projet\Budgetmanager\model\BaseModel as BaseModel;
use Projet\Budgetmanager\model\Database;

class DepenseModel extends BaseModel {

    protected $map = [

        "id_depense" => "idDepense",
        "nom_depense" => "nomDepense",
        "montant" => "montant",
        "date" => "date",
        "id_categorie" => "idCategorie",
        "id_utilisateur" => "idUtilisateur"
    ];

    public int $idDepense;

    public string $nomDepense;

    public int $montant;

    public string $date;

    public int $idCategorie;

    public int $idUtilisateur;

    public function __construct(array $init = [])
    {

        $this->idDepense = $init["id_depense"] ?? -1;

        $this->nomDepense = $init["nom_depense"] ?? "";

        $this->montant = $init["montant"] ?? -1;

        $this->date = $init["date"] ?? "";

        $this->idCategorie = $init["id_categorie"] ?? -1;
        
    }

    public function insertDepense(){

        $query = "INSERT INTO `Depense`
        (`Depense`.`nom_depense`, `Depense`.`montant`, `Depense`.`date`, `Depense`.`id_categorie`, `Depense`.`id_utilisateur`)
        VALUES(:nomDepense, :montant, :date, :idCategorie, :idUtilisateur);";

        $param = [

            ":nomDepense" => $this->nomDepense,
            ":montant" => $this->montant,
            ":date" => $this->date,
            ":idCategorie" => $this->idCategorie,
            ":idUtilisateur" => $this->idUtilisateur

        ];

        DataBase::getDB()->run($query, $param);
        return DataBase::getDB()->lastInsertId();

    }

    public static function selectAllDepenseByUser($idUtilisateur){

        $query = "SELECT *
        FROM `Depense`
        WHERE `Depense`.`id_utilisateur` = :idUtilisateur;";

        $param = [

            ":idDepense" => $idUtilisateur

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetchAll();

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

        try{

            DataBase::getDB()->run($query, $param);

            return true;

        }
        catch(PDOException $exception){

            return $exception;

        }

    }

    public static function deleteDepense($id){

        $query = "DELETE FROM `Depense`
        WHERE `Depense`.`id_depense` = :idDepense;";

        $param = [

            ":idDepense" => $id

        ];

        try{

            DataBase::getDB()->run($query, $param);

            return true;

        }
        catch(PDOException $exception){

            return $exception;

        }

    }
}