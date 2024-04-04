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

use Projet\Budgetmanager\api\php\model\DepenseModel as DepenseModel;

class DepenseCtrl {

    public function createDepense($nom, $montant, $date, $idCategorie, $idUtilisateur) : DepenseModel | array {
        $error = [];

        if ($nom == "" || strlen($nom) >= 100 || strlen($nom) <= 3 || !$nom){

            $error["nom"] = "Le nom de la dépense peut contenir entre 3 et 100 caractères.";

        }

        if ($montant == "" || strlen($montant) > 14 || !$montant){

            $error["montant"] = "Arretez de vous mentir, vous ne gagnez pas autant.";

        }

        $dateSeparer = explode("-", $date);

        if ($date == "" || !checkdate($dateSeparer[1], $dateSeparer[2], $dateSeparer[0]) || !$date){

            $error["date"] = "Veuillez saisir une date correcte dans le format d-m-Y, exemple : 15-03-2024.";
            
        }

        if(empty($error)){

            $depense = new DepenseModel([ 
                "nom_depense" => $nom,
                "montant" => $montant,
                "date" => $date,
                "id_categorie" => $idCategorie,
                "id_utilisateur" => $idUtilisateur
            ]);

            $resultat = $depense->insertDepense();

            if(!is_int($resultat)){

                $error["insertion"] = "Un problème est survenu lors de la création de votre dépense veuillez réessayer.";

                return $error;

            }
            else{

                return $resultat;

            }

        }
        
        return $error;
    }

    public function readDepense($idUtilisateur) {

        $depense = DepenseModel::selectAllDepenseByUser($idUtilisateur);

        if(!$depense){
            $error["read"] = "La dépense que vous essayez de lire n'existe pas, veuillez réessayer.";
            return $error;
        }
        else{
            return $depense;
        }
        
    }

    public function updateDepense($id, $nom, $montant, $date, $idCategorie, $idUtilisateur) {
        $error = [];

        if ($nom == "" || strlen($nom) >= 100 || strlen($nom) <= 3 || !$nom){

            $error["nom"] = "Le nom de la dépense peut contenir entre 3 et 100 caractères.";

        }

        if ($montant == "" || strlen($montant) > 14 || !$montant){

            $error["montant"] = "Arretez de vous mentir, vous ne gagnez pas autant.";

        }

        $dateSeparer = explode("-", $date);

        if ($date == "" || !checkdate($dateSeparer[1], $dateSeparer[2], $dateSeparer[0]) || !$date){
            $error["date"] = "Veuillez saisir une date correcte dans le format d-m-Y, exemple : 15-03-2024.";
        }

        if(empty($error)){

            $depense = DepenseModel::updateDepense($id, $nom, $montant, $date, $idCategorie);

            if (!$depense) {
                $error["modification"] = "Un problème est survenu lors de la modification de votre dépense veuillez réessayer.";
                return $error;
            }
            else{
                return $depense;
            }

        }
        
        return $error;
    }

    public function deleteDepense($id) {

        $depense = DepenseModel::deleteDepense($id);

        if(!$depense){
            $error["delete"] = "La dépense que vous essayez de supprimer n'existe pas, veuillez réessayer.";
            return $error;
        }
        else{
            return $depense;
        }
    }
}