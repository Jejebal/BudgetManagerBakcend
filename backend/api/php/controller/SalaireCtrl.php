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
 
    public function createSalaire($somme, $moisSalaire, $idUtilisateur) : SalaireModel | array {

        $error = [];
 
        if ($somme == "" || strlen($somme) >= 14 || !$somme){
 
            $error["somme"] = "Veuillez entrer un salaire réel.";
 
        }
 
        if ($moisSalaire == "" || $moisSalaire > 12 || $moisSalaire < 1 || !$moisSalaire){

            $error["moisSalaire"] = "Veuillez saisir un mois correct entre 1 et 12.";

        }

        if($idUtilisateur <= 0){

            $error["idUtilisateur"] = "L'utilisateur que vous essayez de liez au salaire ne peux pas existez.";

        }
 
        if(empty($error)){
 
            $salaire = new SalaireModel([ 
                "somme" => $somme,
                "mois_salaire" => $moisSalaire,
                "id_utilisateur" => $idUtilisateur
            ]);
 
            $resultat = $salaire->insertSalaire();
 
            if(!is_int($resultat)){
 
                $error["insertion"] = "Un problème est survenu lors de la création de votre salaire veuillez réessayer.";
 
                return $error;
 
            }

            $salaire = SalaireModel::selectSalaire($resultat);

            if(!is_a($salaire, "Projet\Budgetmanager\api\php\model\SalaireModel")){

                $error["insertion"] = "Un problème est survenu lors de la récupération de votre salaire veuillez réessayer.";
 
                return $error;

            }
            
            return $resultat;
 
        }
         
        return $error;
    }
 
    public function readSalaire($idUtilisateur) : SalaireModel | array {

        $error = [];

        if($idUtilisateur <= 0){

            $error["idGroupe"] = "L'utilisateur que vous essayez de liez au salaire ne peux pas existez.";

        }
 
        $salaire = SalaireModel::selectSalaire($idUtilisateur);
 
        if(!is_a($salaire, "Projet\Budgetmanager\api\php\model\SalaireModel")){

            $error["read"] = "Le salaire que vous essayez de lire n'existe pas, veuillez réessayer.";

            return $error;

        }
        else{

            return $salaire;

        }
         
    }
 
    public function updateSalaire($somme, $moisSalaire, $idUtilisateur) : SalaireModel | array {

        $error = [];
 
        if ($somme == "" || strlen($somme) >= 14 || !$somme){

            $error["somme"] = "Veuillez entrer un salaire réel.";

        }

        $date = explode("-", $moisSalaire);
        
        if(!checkdate($date[2], $date[1], $date[0])){
            
            $error["moisSalaire"] = "La date que vous essayez d'insérez n'est pas valide. La date dois être de format Année-Mois-Jours.";
        
        }

        if($idUtilisateur <= 0){

            $error["idUtilisateur"] = "L'utilisateur que vous essayez de liez au salaire ne peux pas existez.";

        }
        var_dump($error);
        if(empty($error)){

            $salaire = SalaireModel::selectSalaire($idUtilisateur);

            if(!is_a($salaire, "Projet\Budgetmanager\api\php\model\SalaireModel")){

                $error["salaire"] = "Une erreur est survenue l'ore de la récupération de votre salaire veuillez réessayer.";
                return $error;
            }
            
            else{

                $salaire->$moisSalaire=$moisSalaire;

                $salaire->somme = $somme;

                var_dump($salaire);

                $resultat = $salaire->updateSalaire();
                

                if (!is_int($resultat)) {

                    $error["modification"] = "Un problème est survenu lors de la modification de votre salaire veuillez réessayer.";

                    return $error;

                }
                else{

                    return $salaire;

                }

            }

        }
        
        return $error;
    }
    
 }