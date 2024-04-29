<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : SalaireCtrl.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */
 
namespace Projet\Budgetmanager\api\php\controller;
 
use Projet\Budgetmanager\api\php\model\SalaireModel as SalaireModel;
use Projet\Budgetmanager\api\php\model\UserModel;

class SalaireCtrl {
 
    public function readSalaire($idUtilisateur) : SalaireModel | array {

        $error = [];

        if($idUtilisateur <= 0){

            array_push($error, "L'utilisateur que vous essayez d'utilisé ne peux pas existez veuillez réessayez.");

        }

        if(empty($error)){

            $user = UserModel::selectUserById($idUtilisateur);

            if(!is_a($user, UserModel::class)){

                array_push($error, "L'utilisateur que vous essayer d'utiliser n'existe pas.");

                return $error;

            }

            $salaire = SalaireModel::selectSalaire($idUtilisateur);
 
            if(!is_a($salaire, SalaireModel::class)){

                array_push($error, "Le salaire que vous essayez de lire n'existe pas, veuillez réessayer.");

                return $error;

            }
            else{

                return $salaire;

            }

        }

        return $error;
         
    }
 
    public function updateSalaire($somme, $moisSalaire, $idUtilisateur) : SalaireModel | array {

        $error = [];
 
        if ($somme <= 0){

            array_push($error, "Veuillez entrer un salaire réel.");

        }

        $date = explode("-", $moisSalaire);
        
        if(!checkdate($date[2], $date[1], $date[0])){

            array_push($error, "La date que vous essayez d'insérez n'est pas valide. La date dois être de format Année-Mois-Jours.");
        
        }

        if($idUtilisateur <= 0){

            array_push($error, "L'utilisateur que vous essayez de liez au salaire ne peux pas existez.");

        }

        if(empty($error)){

            $salaire = SalaireModel::selectSalaire($idUtilisateur);

            if(!is_a($salaire, SalaireModel::class)){

                array_push($error, "Une erreur est survenue l'ore de la récupération de votre salaire veuillez réessayer.");

                return $error;
            }
            
            else{

                $salaire->moisSalaire = $moisSalaire;

                $salaire->somme = $somme;

                $resultat = $salaire->updateSalaire();
                

                if (!is_int($resultat)) {

                    array_push($error, "Un problème est survenu lors de la modification de votre salaire veuillez réessayer.");

                    return $error;

                }
                else{

                    return $salaire;

                }

            }

        }
        
        return $error;
    }
    
}