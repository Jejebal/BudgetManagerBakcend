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

        if(!$groupe){

            $error["insertion"] = "Un problème est survenu lors de la création de votre groupe veillez réessayer.";

            return $error;

        }
        
        return $groupe;

    }

    public function modifieGroup($idGroupe, $impot, $loyer, $credits, $moisBudget) : GroupeModel | array {

        $error = [];

        if($idGroupe <= 0){

            $error["idGroupe"] = "Le groupe que vous essayez de modifier ne peux pas existez.";

        }

        if($impot < 0){

            $error["impot"] = "L'impôt que vous essayez d'entrez n'est pas valide. Il dois être plus grand que 0.";

        }

        if($loyer < 0){

            $error["loyer"] = "Le loyer que vous essayez d'entrez n'est pas valide. Il dois être plus grand que 0.";

        }

        if($credits < 0){

            $error["credits"] = "Les crédits que vous essayez d'entrez ne sont pas valide. Ils doivent être plus grand que 0.";

        }

        if(!strtotime($moisBudget)){

            $date = explode("-", $moisBudget);

            if(!checkdate($date[0], $date[1], $date[3])){

                $error["moisBudget"] = "La date que vous essayez d'insérez n'est pas valide. La date dois être de format Année-Mois-Jours.";

            }

        }

        if(empty($error)){

            $groupe = GroupeModel::selectGroupe($idGroupe);

            if(!$groupe){

                $error["groupe"] = "Une erreur est survenue l'ore de la récupération de votre groupe veuillez réessayer.";

                return $error;

            }
            else{

                $groupe->updateGroupe();

                if($groupe){

                    return $groupe;

                }
                else{

                    $error["modification"] = "Une erreur est survenue l'ore de la modification de votre groupe veuillez réessayer.";

                    return $error;

                }

            }

        }

    }

    public function getGroupe($idGroupe) : GroupeModel | array {

        $error = [];

        if($idGroupe <= 0){

            $error["idGroupe"] = "Le groupe que vous essayez de modifier ne peux pas existez.";

        }

        if(empty($error)){

            $groupe = GroupeModel::selectGroupe($idGroupe);

            if(!$groupe){

                $error["groupe"] = "Une erreur est survenue l'ore de la récupération de votre groupe veuillez réessayer.";

                return $error;

            }
            
            return $groupe;

        }

    }

}