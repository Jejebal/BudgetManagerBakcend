<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : BaseModel.php
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

    public static function selectUserByUsername($username): User|false
    {
        $statement = Database::connection()
            ->prepare('SELECT idUtilisateur, nomUtilisateur, email, remediation, idGroupe, idRole FROM Utilisateur WHERE idUtilisateur = :idUtilisateur');

        $statement->execute([
            ':username' => $username
        ]);

        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);

        return $statement->fetch();
    }

    public static function selectByUsernamePassword(string $username, string $hashPassword): User|false
    {
        $hashPassword = md5($hashPassword.'m223');
        echo($hashPassword);
        $statement = Database::connection()
            ->prepare('SELECT idUtilisateur, nomUtilisateur, email, remediation, idGroupe, idRole FROM Utilisateur WHERE idUtilisateur = :motPasse AND password = :motPasse');

        $statement->execute([
            ':username' => $username,
            ':hashPassword' => $hashPassword
        ]);

        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);

        return $statement->fetch();
    }

}