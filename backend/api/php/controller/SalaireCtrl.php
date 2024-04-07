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

            $error["idUtilisateur"] = "L'utilisateur que vous essayez d'utilisé ne peux pas existez veuillez réessayez.";

        }

        if(empty($error)){

            $user = UserModel::selectUserById($idUtilisateur);

            if(!is_a($user, UserModel::class)){

                $error["utilisateur"] = "L'utilisateur que vous essayer d'utiliser n'existe pas.";

                return $error;

            }

            $salaire = SalaireModel::selectSalaire($idUtilisateur);
 
            if(!is_a($salaire, SalaireModel::class)){

                $error["read"] = "Le salaire que vous essayez de lire n'existe pas, veuillez réessayer.";

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

            $error["somme"] = "Veuillez entrer un salaire réel.";

        }

        $date = explode("-", $moisSalaire);
        
        if(!checkdate($date[2], $date[1], $date[0])){
            
            $error["moisSalaire"] = "La date que vous essayez d'insérez n'est pas valide. La date dois être de format Année-Mois-Jours.";
        
        }

        if($idUtilisateur <= 0){

            $error["idUtilisateur"] = "L'utilisateur que vous essayez de liez au salaire ne peux pas existez.";

        }

        if(empty($error)){

            $salaire = SalaireModel::selectSalaire($idUtilisateur);

            if(!is_a($salaire, SalaireModel::class)){

                $error["salaire"] = "Une erreur est survenue l'ore de la récupération de votre salaire veuillez réessayer.";
                return $error;
            }
            
            else{

                $salaire->moisSalaire = $moisSalaire;

                $salaire->somme = $somme;

                $resultat = $salaire->updateSalaire();
                

                if (!is_int($resultat)) {

                    $error["modification"] = "Un problème est survenu lors de la modification de votre salaire veuillez réessayer.";

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