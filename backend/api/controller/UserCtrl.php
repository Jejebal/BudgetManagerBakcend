<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : UserCtrl.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\controller;

use Projet\Budgetmanager\model\UserModel as UserModel;

class UserCtrl {

    public function creatAdmin($nom, $email, $motPasse, $remediation, $idGroupe){

        if(strlen($nom) >= 3 && (str_contains($email, "@") && str_contains($email, "."))){
            
        }

    }

    public function creatMember(){



    }

}