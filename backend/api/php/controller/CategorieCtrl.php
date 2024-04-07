<?php

/**
* 
* Project : Budget manager
* Description : Une application de gestion de budget et de dépenses monétaire.
* File : CategorieCtrl.php
* Authors : Jérémy Ballanfat, Illya Nuzhny
* Date : 8 mars 2024
* 
*/

namespace Projet\Budgetmanager\api\php\controller;

use Projet\Budgetmanager\api\php\model\CategorieModel as CategorieModel;

class CategorieCtrl {

    public function readAllCategorie() {

        $categorie = CategorieModel::selectAllCategorie();

        if(!$categorie){

            $error["read"] = "Une erreur est survenue, veuillez réessayer.";
            return $error;

        }
        else{

            return $categorie;
            
        }
        
    }
}