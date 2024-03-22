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

}