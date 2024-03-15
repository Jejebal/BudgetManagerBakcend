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
 
    public function readCategorie($id) {

        $categorie = CategorieModel::selectCategorie($id);

        if(!$categorie){
            $error["read"] = "La categorie que vous essayez de lire n'existe pas, veuillez réessayer.";
            return $error;
        }
        else{
            return $categorie;
        }
        
    }
}