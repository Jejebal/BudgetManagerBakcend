<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : DepenseCtrl.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\controller;

use Projet\Budgetmanager\model\DepenseModel as DepenseModel;

class DepenseCtrl {

    public function createDepense($nom, $montant, $date, $idCategorie){

        $error = [];

        if (strlen($nom) >= 100 || strlen($nom) <= 3) {

            $error["nom"] = "Le nom de la dépense peut contenir entre 3 et 100 caractères";

        }

        if (strlen($montant) > 14) {

            $error["montant"] = "Arretez de vous mentir, vous ne gagnez pas autant que ça";

        }

        

    }
}