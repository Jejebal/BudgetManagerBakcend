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

        $historique = [];

        if($idGroupe <= 0){

            $error["groupe"] = "Le groupe que vous essayez d'utiliser ne peut pas exister.";

        }

        if(empty($error)){

            $groupe = GroupeModel::selectGroupe($idGroupe);

            if(!is_a($groupe, GroupeModel::class)){

                $error["groupe"] = "Le groupe que vous essayer d'utiliser n'existe pas.";

                return $error;

            }
            else{

                $listUser = UserModel::selectUserByGroupe($idGroupe);

                if(is_array($listUser)){

                    foreach($listUser as $user){

                        $listDepense = DepenseModel::selectAllDepenseByUser($user->idUtilisateur);

                        if(is_array($listDepense)){

                            $historique[$user->nomUtilisateur] = $listDepense;

                        }
                        else{

                            $historique[$user->nomUtilisateur] = null;

                        }
    
                    }
    
                    return $historique;

                }

                $error["recuperation"] = "Un problème est survenu lors de la récupération des utilisateur du groupe veuillez réessayer.";

                return $error;

            }

        }

    } 

}