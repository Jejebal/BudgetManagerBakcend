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

namespace Projet\Budgetmanager\api\php\controller;

use Projet\Budgetmanager\api\php\model\GroupeModel;
use Projet\Budgetmanager\api\php\model\UserModel;
use Projet\Budgetmanager\api\php\model\SalaireModel;

class UserCtrl {

    public function createAdmin($nom, $email, $motPasse, $remediation, $groupeCtrl) : UserModel | array {

        $error = [];

        if($nom == "" || strlen($nom) < 3 || strlen($nom) > 100 || !$nom){

            array_push($error, "Le nom que vous essayez d'utiliser n'est pas valide. Il doit être plus grand que 3 et plus petit que 100.");

        }

        if($email == "" || strlen($email) < 7 ||strlen($email) > 100 || !$email){

            array_push($error, "L'email que vous essayez d'ajouter n'est pas valide.");

        }
        
        if($motPasse == "" || strlen($motPasse) < 5 || strlen($motPasse) > 50 || !$motPasse){

            array_push($error, "Le mot de passe que vous essayez d'utiliser n'est pas valide. Il dois être plus grand que 5 et plus petit que 50.");

        }

        if($remediation <= 0 || $remediation > 29){

            array_push($error, "La remediation que vous essayez d'utiliser n'est pas valide. Elle dois être plus grand que 0 et plus petit que 29.");

        }

        if(empty($error)){

            $result = UserModel::selectUserByUsername($nom);

            if(!is_a($result, UserModel::class)){

                $groupeId = $groupeCtrl->createGroupe();

                if(is_array($groupeId)){

                    return $groupeId;

                }
                else{

                    $user = new UserModel([ 
                        "nom_utilisateur" => $nom,
                        "email" => $email,
                        "mot_passe" => $motPasse,
                        "remediation" => $remediation,
                        "id_groupe" => $groupeId
                    ]);
        
                    $resultat = $user->insertUser();
        
                    if(!is_string($resultat)){
        
                        array_push($error, "Un problème est survenu lors de la création de votre compte veuillez réessayer.");
        
                        return $error;
        
                    }
    
                    $user = UserModel::selectUserByUsername($resultat);
    
                    if(!is_a($user, UserModel::class)){
    
                        array_push($error, "Un problème est survenu lors de la récupération de votre compte veuillez réessayer.");
        
                        return $error;
    
                    }

                    $salaire = SalaireModel::insertSalaire($user->idUtilisateur);

                    if(!is_int($salaire)){

                        array_push($error, "Un problème est survenu lors de la récupération de votre compte veuillez réessayer.");
        
                        return $error;

                    }
    
                    $user->motPasse = "";
        
                    return $user;

                }

            }

            array_push($error, "Le nom d'utilisateur que vous essayez de créer existe déjà.");

            return $error;

        }
        
        return $error;

    }

    public function createMember($nom, $motPasse, $remediation, $idGroupe) : UserModel | array{

        $error = [];

        if($nom == "" || strlen($nom) < 3 || strlen($nom) > 100 || !$nom){

            array_push($error, "Le nom que vous essayez d'utiliser n'est pas valide. Il dois être plus grand que 3 et plus petit que 100.");

        }
        
        if($motPasse == "" || strlen($motPasse) < 5 || strlen($motPasse) > 50 || !$motPasse){

            array_push($error, "Le mot de passe que vous essayez d'utiliser n'est pas valide. Il dois être plus grand que 5 et plus petit que 50.");

        }

        if($remediation <= 0 || $remediation > 29){

            array_push($error, "La remediation que vous essayez d'utiliser n'est pas valide. Elle dois être plus grand que 0 et plus petit que 29.");

        }

        if($idGroupe <= 0){

            array_push($error, "Le groupe que vous essayez d'utiliser ne peut pas exister.");

        }

        if(empty($error)){

            $groupe = GroupeModel::selectGroupe($idGroupe);

            if(!is_a($groupe, GroupeModel::class)){

                array_push($error, "Le groupe que vous essayer d'utiliser n'existe pas.");

                return $error;

            }
            else{

                $user = new UserModel([ 
                    "nom_utilisateur" => $nom,
                    "mot_passe" => password_hash($motPasse, PASSWORD_DEFAULT),
                    "remediation" => $remediation,
                    "id_groupe" => $idGroupe
                ]);
    
                $resultat = $user->insertUser();
    
                if(!is_string($resultat)){
    
                    array_push($error, "Un problème est survenu lors de la création de votre compte veuillez réessayer.");
    
                    return $error;
    
                }
                
                $user = UserModel::selectUserByUsername($resultat);
    
                if(!is_a($user, UserModel::class)){
    
                    array_push($error, "Un problème est survenu lors de la récupération de votre compte veuillez réessayer.");
    
                    return $error;
    
                }

                $salaire = SalaireModel::insertSalaire($user->idUtilisateur);

                if(!is_int($salaire)){

                    array_push($error, "Un problème est survenu lors de la récupération de votre compte veuillez réessayer.");
        
                    return $error;

                }
    
                $user->motPasse = "";
    
                return $user;

            }

        }
        
        return $error;

    }

    public function checkLogin($nom, $motPasse) : UserModel | array {

        $error = [];

        if($nom == "" || strlen($nom) < 3 || strlen($nom) > 100 || !$nom){

            array_push($error, "Le nom que vous essayez d'utiliser ne peux pas exister. Il dois être plus grand que 3 et plus petit que 100.");

        }

        if($motPasse == "" || strlen($motPasse) < 5 || strlen($motPasse) > 50 || !$motPasse){

            array_push($error, "Le mot de passe que vous essayez d'utiliser ne peux pas exister. Il dois être plus grand que 5 et plus petit que 50.");

        }

        if(empty($error)){

            $user = UserModel::verifyPassword($nom, $motPasse);

            if(!$user){

                array_push($error, "Le compte que vous essayez d'utiliser n'existe pas ou le mot de passe que vous avez rentré n'est pas le bon, veuillez réessayer.");
                return $error;

            }
            else{

                return $user;

            }

        }
        else{

            return $error;

        }

    }

}