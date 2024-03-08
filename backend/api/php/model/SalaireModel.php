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

namespace Projet\Budgetmanager\model;

use Projet\Budgetmanager\model\BaseModel as BaseModel;

use Projet\Budgetmanager\model\Database as Database;

class SalaireModel extends BaseModel {

    protected $map = [

        "id_salaire" => "idSalaire",
        "somme" => "somme",
        "mois_salaire" => "moisSalaire",
        "id_utilisateur" => "idUtilisateur",

    ];

    public int $idSalaire;

    public int $somme;

    public string $moisSalaire;

    public int $idUtilisateur;

    public function __construct(array $init = [])
    {

        $this->idSalaire = $init["id_salaire"] ?? -1;

        $this->somme = $init["somme"] ?? -1;

        $this->moisSalaire = $init["mois_salaire"] ?? "";

        $this->idUtilisateur = $init["id_utilisateur"] ?? -1;
        
    }

    public function insertSalaire(){

        $query = "INSERT INTO `Salaire`
        (`somme`, `mois_salaire`, `id_utilisateur`)
        VALUES(:somme, :moisSalaire, :idUtilisateur);";

        $param = [

            ":somme" => $this->somme,
            ":moisSalaire" => $this->moisSalaire,
            ":idUtilisateur" => $this->idUtilisateur

        ];

        $statement = DataBase::getDB()->run($query, $param);
        return DataBase::getDB()->lastInsertId();

    }

    public static function selectSalaire($id){

        $query = "SELECT *
        FROM `Salaire`
        WHERE `Salaire`.`id_salaire` = :idSalaire;";

        $param = [

            ":idSalaire" => $id

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }

    public static function updateSalaire($id, $somme, $moisSalaire, $idUtilisateur){

        $query = "UPDATE `Salaire`
        SET `somme` = :somme, `mois_salaire` = :moisSalaire, `id_utilisateur` = :idUtilisateur
        WHERE `id_Salaire` = :idSalaire;";

        $param = [

            ":idSalaire" => $id,
            ":somme" => $somme,
            ":moisSalaire" => $moisSalaire,
            ":idUtilisateur" => $idUtilisateur

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }
}