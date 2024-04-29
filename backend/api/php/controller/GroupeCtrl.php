<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : login/index.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\api\php\controller;

use Projet\Budgetmanager\api\php\model\GroupeModel;

class GroupeCtrl {

    public function createGroupe() : int | array{

        $error = [];
        
        $groupe = GroupeModel::insertGroupe();

        if(!is_int($groupe)){

            array_push($error, "Un problème est survenu lors de la création de votre groupe veillez réessayer.");

            return $error;

        }
        
        return $groupe;

    }

    public function modifieGroup($idGroupe, $impot, $loyer, $credits, $moisBudget) : GroupeModel | array {

        $error = [];

        if($idGroupe <= 0){

            array_push($error, "Le groupe que vous essayez de modifier ne peux pas existez.");

        }

        if($impot < 0){

            array_push($error, "L'impôt que vous essayez d'entrez n'est pas valide. Il dois être plus grand que 0.");

        }

        if($loyer < 0){

            array_push($error, "Le loyer que vous essayez d'entrez n'est pas valide. Il dois être plus grand que 0.");

        }

        if($credits < 0){

            array_push($error, "Les crédits que vous essayez d'entrez ne sont pas valide. Ils doivent être plus grand que 0.");

        }
        
        $date = explode("-", $moisBudget);
        
        if(!checkdate($date[2], $date[1], $date[0])){
            
            array_push($error, "La date que vous essayez d'insérez n'est pas valide. La date dois être de format Année-Mois-Jours.");
        
        }

        if(empty($error)){

            $groupe = GroupeModel::selectGroupe($idGroupe);

            if(!$groupe){

                array_push($error, "Une erreur est survenue l'ore de la récupération de votre groupe veuillez réessayer.");

                return $error;

            }
            else{

                $groupe->impots = $impot;
                $groupe->loyer = $loyer;
                $groupe->credit = $credits;
                $groupe->moisBudget = $moisBudget;

                $resulta = $groupe->updateGroupe();

                if(is_int($resulta)){

                    return $groupe;

                }
                else{

                    array_push($error, "Une erreur est survenue l'ore de la modification de votre groupe veuillez réessayer.");

                    return $error;

                }

            }

        }

        return $error;

    }

    public function getGroupe($idGroupe) : GroupeModel | array {

        $error = [];

        if($idGroupe <= 0){

            array_push($error, "Le groupe que vous essayez de récupérez ne peux pas existez.");

        }

        if(empty($error)){

            $groupe = GroupeModel::selectGroupe($idGroupe);

            if(!is_a($groupe, GroupeModel::class)){

                array_push($error, "Une erreur est survenue l'ore de la récupération de votre groupe veuillez réessayer.");

                return $error;

            }
            
            return $groupe;

        }

        return $error;

    }

}