<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : SalaireCtrl.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */
 
 namespace Projet\Budgetmanager\api\php\controller;
 
 use Projet\Budgetmanager\api\php\model\SalaireModel as SalaireModel;
 
 class SalaireCtrl {
 
     public function createSalaire($somme, $moisSalaire, $idUtilisateur) {
         $error = [];
 
         if ($somme == "" || strlen($somme) >= 14 || !$somme){
 
             $error["somme"] = "Veuillez entrer un salaire réel.";
 
         }
 
         if ($moisSalaire == "" || $moisSalaire > 12 || $moisSalaire < 1 || !$moisSalaire){
             $error["moisSalaire"] = "Veuillez saisir un mois correct entre 1 et 12.";
         }
 
         if(empty($error)){
 
             $salaire = new SalaireModel($init = [ 
                 "somme" => $somme,
                 "mois_salaire" => $moisSalaire,
                 "id_utilisateur" => $idUtilisateur
             ]);
 
             $resultat = $salaire->insertSalaire();
 
             if(!$resultat){
 
                 $error["insertion"] = "Un problème est survenu lors de la création de votre salaire veuillez réessayer.";
 
                 return $error;
 
             }
             else{
 
                 return $resultat;
 
             }
 
         }
         
         return $error;
     }
 
     public function readSalaire($idUtilisateur) {
 
         $salaire = SalaireModel::selectSalaire($idUtilisateur);
 
         if(!$salaire){
             $error["read"] = "Le salaire que vous essayez de lire n'existe pas, veuillez réessayer.";
             return $error;
         }
         else{
             return $salaire;
         }
         
     }
 
     public function updateSalaire($id, $somme, $moisSalaire, $idUtilisateur) {
        $error = [];
 
        if ($somme == "" || strlen($somme) >= 14 || !$somme){

            $error["somme"] = "Veuillez entrer un salaire réel.";

        }

        if ($moisSalaire == "" || $moisSalaire > 12 || $moisSalaire < 1 || !$moisSalaire){
            $error["moisSalaire"] = "Veuillez saisir un mois correct entre 1 et 12.";
        }

        if(empty($error)){

            $salaire = SalaireModel::updateSalaire($id, $somme, $moisSalaire, $idUtilisateur);

            if (!$salaire) {
                $error["modification"] = "Un problème est survenu lors de la modification de votre salaire veuillez réessayer.";
                return $error;
            }
            else{
                return $salaire;
            }

        }
        
        return $error;
    }
    
 }