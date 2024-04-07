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

namespace Projet\Budgetmanager\api\php\controller;

use Projet\Budgetmanager\api\php\model\DepenseModel;
use Projet\Budgetmanager\api\php\model\CategorieModel;
use Projet\Budgetmanager\api\php\model\UserModel;

class DepenseCtrl {

    public function createDepense($nom, $montant, $idCategorie, $idUtilisateur) : DepenseModel | array {
        
        $error = [];

        if ($nom == "" || strlen($nom) >= 100 || strlen($nom) <= 3 || !$nom){

            $error["nom"] = "Le nom de la dépense peut contenir entre 3 et 100 caractères.";

        }

        if ($montant == "" || strlen($montant) > 14 || !$montant){

            $error["montant"] = "Arretez de vous mentir, vous ne gagnez pas autant.";

        }

        if($idCategorie <= 0){

            $error["idCategorie"] = "La catégorie que vous essayez d'utilisé ne peux pas existez.";

        }

        if($idUtilisateur <= 0){

            $error["idUtilisateur"] = "L'utilisateur que vous essayez d'utilisé ne peux pas existez.";

        }

        if(empty($error)){

            $categorie = CategorieModel::selectCategorieById($idCategorie);

            if(!is_a($categorie, CategorieModel::class)){

                $error["categorie"] = "La catégorie que vous essayez de liez a votre dépense n'existe pas veuillez réessayez.";
                return $error;

            }

            $user = UserModel::selectUserById($idUtilisateur);

            if(!is_a($user, UserModel::class)){

                $error["utilisateur"] = "L'utilisateur que vous essayez de liez a votre dépense n'existe pas veuillez réessayez.";
                return $error;

            }

            $depense = new DepenseModel([ 
                "nom_depense" => $nom,
                "montant" => $montant,
                "date" => date("Y-m-d"),
                "id_categorie" => $idCategorie,
                "id_utilisateur" => $idUtilisateur
            ]);

            $resultat = $depense->insertDepense();

            if(!is_int($resultat)){

                $error["insertion"] = "Un problème est survenu lors de la création de votre dépense veuillez réessayer.";

                return $error;

            }
            else{

                $depense->idDepense = $resultat;
                return $depense;

            }

        }
        
        return $error;
    }

    public function readSumDepense($idUtilisateur) {

        $error = [];

        if($idUtilisateur <= 0){

            $error["idUtilisateur"] = "L'utilisateur que vous essayez d'utilisé ne peux pas existez.";

        }

        if(empty($error)){

            $user = UserModel::selectUserById($idUtilisateur);

            if(!is_a($user, UserModel::class)){

                $error["utilisateur"] = "L'utilisateur que vous essayez d'utilisé n'existez pas.";

            }

            $depense = DepenseModel::selectSumDepenseByUserByMonth($idUtilisateur);

            if(!is_array($depense)){
    
                $error["read"] = "La somme des dépenses du mois que vous essayez de lire n'existe pas, veuillez réessayer.";
                return $error;
            }
    
            else{
    
                return $depense[0];
    
            }

        }
        
    }
    
}