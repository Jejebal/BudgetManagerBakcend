<?php

/**
* 
* Project : Budget manager
* Description : Une application de gestion de budget et de dépenses monétaire.
* File : RoleCtrl.php
* Authors : Jérémy Ballanfat, Illya Nuzhny
* Date : 8 mars 2024
* 
*/

namespace Projet\Budgetmanager\api\php\controller;

use Projet\Budgetmanager\api\php\model\RoleModel as RoleModel;

class RoleCtrl {
 
    public function readRole($idRole) : RoleModel | array {

        if($idRole <= 0){

            $error["idRole"] = "Le rôle que vous essayez de récupérez ne peux pas existez.";

        }

        $role = RoleModel::selectRole($idRole);

        if(!is_a($role, "Projet\Budgetmanager\api\php\model\RoleModel")){

            $error["read"] = "Le role que vous essayez de lire n'existe pas, veuillez réessayer.";

            return $error;

        }
        else{

            return $role;

        }
        
    }
}