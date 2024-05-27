<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : Historique.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 4 avril 2024
 * 
 */

namespace Projet\Budgetmanager\api\php\controller;

use Projet\Budgetmanager\api\php\model\UserModel;
use Projet\Budgetmanager\api\php\model\DepenseModel;
use Projet\Budgetmanager\api\php\model\GroupeModel;

class HistoriqueCtrl {

    public function getAllHistorique($idGroupe){

        $error = [];

        $listNom = [];

        $listArrayDepenses = [];

        $historique = [];

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

                $listUser = UserModel::selectUserByGroupe($idGroupe);

                if(is_array($listUser)){

                    foreach($listUser as $user){

                        array_push($listNom, $user->nomUtilisateur);

                        $listDepense = DepenseModel::selectAllDepenseByUser($user->idUtilisateur);

                        array_push($listArrayDepenses, $listDepense);
    
                    }

                    $historique = [

                        "Utilisateurs" => $listNom,
                        "Depenses" => $listArrayDepenses

                    ];
    
                    return $historique;

                }

                array_push($error, "Un problème est survenu lors de la récupération des utilisateur du groupe veuillez réessayer.");

                return $error;

            }

        }

    } 

}