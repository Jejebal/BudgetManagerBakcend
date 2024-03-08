<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : UserCtrl.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\controller;

use Projet\Budgetmanager\model\UserModel as UserModel;

class UserCtrl {

    public function creatAdmin($nom, $email, $motPasse, $remediation, $idGroupe){

        $error = [];

        if($nom == "" || strlen($nom) < 3 || strlen($nom) > 100 || !$nom){

            $error["nom"] = "Le nom que vous essayer d'utiliser n'est pas valide. Il dois être plus grand que 3 et plus petit que 100.";

        }

        if($email == "" || strlen($email) < 7 ||strlen($email) > 100 || !$email){

            $error["email"] = "L'email que vous essayer d'ajouter n'est pas valide.";

        }
        
        if($motPasse == "" || strlen($motPasse) < 5 || strlen($motPasse) > 50 || !$motPasse){

            $error["motPasse"] = "Le mot de passe que vous essayez d'utiliser n'est pas valide. Il dois être plus grand que 5 et plus petit que 50.";

        }

        if($remediation <= 0 || $remediation > 29){

            $error["remediation"] = "La remediation que vous essayer d'utiliser n'est pas valide. Elle dois être plus grand que 0 et plus petit que 29.";

        }

        if($idGroupe <= 0){

            $error["groupe"] = "Le groupe que vous essayer d'utiliser ne peut pas existez.";

        }

        if(empty($error)){

            $user = new UserModel($init = [ 
                "nom_utilisateur" => $nom,
                "email" => $email,
                "mot_passe" => password_hash($motPasse, PASSWORD_DEFAULT),
                "remediation" => $remediation,
                "id_groupe" => $idGroupe
            ]);

            return $user->creatUser();

        }
        
        return $error;

    }

    public function creatMember(){



    }

}