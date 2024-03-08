<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : UserModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\model;

use Projet\Budgetmanager\model\BaseModel as BaseModel;
use Projet\Budgetmanager\model\Database;

class UserModel extends BaseModel {

    protected $map = [

        "id_utilisateur" => "idUtilisateur",
        "nom_utilisateur" => "nomUtilisateur",
        "email" => "email",
        "mot_passe" => "motPasse",
        "remediation" => "remediation",
        "id_groupe" => "idGroupe",
        "id_role" => "idRole"
    ];

    public int $idUtilisateur;

    public string $nomUtilisateur;

    public string $email;

    public string $motPasse;

    public int $remediation;

    public int $idGroupe;

    public int $idRole;

    public function __construct(array $init = [])
    {
        
        $this->idUtilisateur = $init["id_utilisateur"] ?? -1;

        $this->nomUtilisateur = $init["nom_utilisateur"] ?? "";

        $this->email = $init["email"] ?? "";

        $this->motPasse = $init["mot_passe"] ?? "";

        $this->remediation = $init["remediation"] ?? -1;

        $this->idGroupe = $init["id_groupe"] ?? -1;

        $this->idRole = $init["id_role"] ?? -1;

    }

    public static function selectUserByUsername($nom) : UserModel | false{
        
        $query = "SELECT *
        FROM `Utilisateur`
        WHERE `Utilisateur`.`nomUtilisateur` = :nomUtilisateur;";

        $param = [

            ":nomUtilisateur" => $nom

        ];

        $statement = Database::getDB()->run($query, $param);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetch();

    }
    
    public static function verifiPassword($nom, $motPasse) : UserModel | false{

        $user = UserModel::selectUserByUsername($nom);

        if(password_verify($motPasse, $user->motPasse)){

            $user->motPasse = "";

            return $user;

        }
        else {

            return false;

        }

    }

    public function creatUser($nom, $email = null, $motPasse, $remediation, $idGroupe) : int | false{

        $motPasse = password_hash($motPasse, PASSWORD_DEFAULT);

        if($email == null){

            $query = "INSERT INTO `Utilisateur` (`Utilisateur`.`nom_utilisateur`, `Utilisateur`.`mot_passe`, `Utilisateur`.`remediation` `Utilisateur`.`id_groupe`, `Utilisateur`.`id_role`)
            VALUES (:nomUtilisateur, :motPasse, :remediation, :idGroupe, 1);";

            $param = [

                ":nomUtilisateur" => $nom,
                ":email" => $email,
                ":motPasse" => $motPasse,
                ":remediation" => $remediation,
                ":idGroupe" => $idGroupe

            ];

        }
        else{

            $query = "INSERT INTO `Utilisateur` (`Utilisateur`.`nom_utilisateur`, `Utilisateur`.`mot_passe`, `Utilisateur`.`remediation` `Utilisateur`.`id_groupe`, `Utilisateur`.`id_role`)
            VALUES (:nomUtilisateur, :email, :motPasse, :remediation, :idGroupe, 2);";

            $param = [

                ":nomUtilisateur" => $nom,
                ":email" => $email,
                ":motPasse" => $motPasse,
                ":remediation" => $remediation,
                ":idGroupe" => $idGroupe

            ];

        }

        Database::getDB()->run($query, $param);
        return DataBase::getDB()->lastInsertId();

    }



}