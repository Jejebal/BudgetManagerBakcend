<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : GroupeModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\model;

use Projet\Budgetmanager\model\BaseModel as BaseModel;

use Projet\Budgetmanager\model\Database as Database;

class GroupeModel extends BaseModel {

    protected $map = [

        "id_groupe" => "idGroupe",
        "impots" => "impots",
        "loyer" => "loyer",
        "credit" => "credit",
        "mois_budget" => "moisBudget"

    ];

    public int $idGroupe;

    public float $impots;

    public float $loyer;

    public float $credit;

    public string $moisBudget;

    public function __construct(array $init = [])
    {

        $this->idGroupe = $init["id_groupe"] ?? -1;

        $this->impots = $init["impots"] ?? -1;

        $this->loyer = $init["loyer"] ?? -1;

        $this->credit = $init["credit"] ?? -1;

        $this->moisBudget = $init["mois_budget"] ?? "";
        
    }

    public static function selectGroupe($id) : GroupeModel | false{

        $query = "SELECT *
        FROM `Groupe`
        WHERE `Groupe`.`id_groupe` = :idGroupe;";

        $param = [

            ":idGroupe" => $id

        ];

        $statement = DataBase::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, __CLASS__);
        return $statement->fetch();

    }

    public function insertGroupe() : int | false {

        $query = "INSERT INTO `Groupe` (`Groupe`.`impots`, `Groupe`.`loyer`, `Groupe`.`credit`, `Groupe`.`mois_budget`) 
        VALUES (0.0, 0.0, 0.0, 0)";

        Database::getDB()->run($query);
        return DataBase::getDB()->lastInsertId();

    }

}