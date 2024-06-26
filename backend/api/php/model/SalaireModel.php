<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : SalaireModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\api\php\model;

use PDOException;
use Projet\Budgetmanager\api\php\model\BaseModel as BaseModel;

use Projet\Budgetmanager\api\php\model\Database as Database;

class SalaireModel extends BaseModel {

    protected $map = [

        "id_salaire" => "idSalaire",
        "somme" => "somme",
        "mois_salaire" => "moisSalaire",
        "id_utilisateur" => "idUtilisateur",

    ];

    public int $idSalaire;

    public float $somme;

    public string $moisSalaire;

    public int $idUtilisateur;

    public function __construct(array $init = [])
    {

        $this->idSalaire = $init["id_salaire"] ?? -1;

        $this->somme = $init["somme"] ?? -1;

        $this->moisSalaire = $init["mois_salaire"] ?? "";

        $this->idUtilisateur = $init["id_utilisateur"] ?? -1;
        
    }

    public static function insertSalaire($idUtilisateur) : int | false | PDOException {

        $query = "INSERT INTO `Salaire`
        (`somme`, `mois_salaire`, `id_utilisateur`)
        VALUES(0.0, 0, :idUtilisateur);";

        $param = [

            ":idUtilisateur" => $idUtilisateur

        ];

        try {

            $statement = DataBase::getDB()->run($query, $param);
            return DataBase::getDB()->lastInsertId();

        }
        catch(PDOException $exception){

            return $exception;

        }

    }

    public static function selectSalaire($idUtilisateur) : SalaireModel | false | PDOException {

        $query = "SELECT *
        FROM `Salaire`
        WHERE `Salaire`.`id_utilisateur` = :idUtilisateur;";

        $param = [

            ":idUtilisateur" => $idUtilisateur

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

    public function updateSalaire() : int | PDOException {

        $query = "UPDATE `Salaire`
        SET `somme` = :somme, `mois_salaire` = :moisSalaire, `id_utilisateur` = :idUtilisateur
        WHERE `id_Salaire` = :idSalaire;";

        $param = [

            ":idSalaire" => $this->idSalaire,
            ":somme" => $this->somme,
            ":moisSalaire" => $this->moisSalaire,
            ":idUtilisateur" => $this->idUtilisateur

        ];

        try {

            DataBase::getDB()->run($query, $param);

            return $this->idSalaire;

        }
        catch(PDOException $exception){

            return $exception;

        }

    }
}