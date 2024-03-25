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

namespace Projet\Budgetmanager\api\php\model;

use PDOException;
use Projet\Budgetmanager\api\php\model\BaseModel as BaseModel;
use Projet\Budgetmanager\api\php\model\Database;

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

    public ?string $email;

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

    public static function selectUserByUsername($nom) : UserModel | false | PDOException {
        
        $query = "SELECT *
        FROM `Utilisateur`
        WHERE `Utilisateur`.`nom_utilisateur` = :nomUtilisateur;";

        $param = [

            ":nomUtilisateur" => $nom

        ];

        try {

            $statement = Database::getDB()->run($query, $param);
            $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
            return $statement->fetch();

        }
        catch(PDOException $exception){

            return $exception;

        }

    }
    
    public static function verifyPassword($nom, $motPasse) : UserModel | false{

        $user = UserModel::selectUserByUsername($nom);

        if(!$user || !is_a($user, "Projet\Budgetmanager\api\php\model\UserModel")){

            return false;

        }

        if(password_verify($motPasse, $user->motPasse)){

            $user->motPasse = "";

            return $user;

        }
        else {

            return false;

        }

    }

    public function insertUser() : int | PDOException {

        $this->motPasse = password_hash($this->motPasse, PASSWORD_DEFAULT);

        if($this->email == null){

            $query = "INSERT INTO `Utilisateur` (`Utilisateur`.`nom_utilisateur`, `Utilisateur`.`mot_passe`, `Utilisateur`.`remediation`, `Utilisateur`.`id_groupe`, `Utilisateur`.`id_role`)
            VALUES (:nomUtilisateur, :motPasse, :remediation, :idGroupe, 1);";

            $param = [

                ":nomUtilisateur" => $this->nomUtilisateur,
                ":motPasse" => $this->motPasse,
                ":remediation" => $this->remediation,
                ":idGroupe" => $this->idGroupe

            ];

        }
        else{

            $query = "INSERT INTO `Utilisateur` (`Utilisateur`.`nom_utilisateur`, `Utilisateur`.`email`, `Utilisateur`.`mot_passe`, `Utilisateur`.`remediation`, `Utilisateur`.`id_groupe`, `Utilisateur`.`id_role`)
            VALUES (:nomUtilisateur, :email, :motPasse, :remediation, :idGroupe, 2);";

            $param = [

                ":nomUtilisateur" => $this->nomUtilisateur,
                ":email" => $this->email,
                ":motPasse" => $this->motPasse,
                ":remediation" => $this->remediation,
                ":idGroupe" => $this->idGroupe

            ];

        }

        try{

            Database::getDB()->run($query, $param);

            return $this->nomUtilisateur;

        }
        catch(PDOException $exception){

            return $exception;

        }
                      
    }



}