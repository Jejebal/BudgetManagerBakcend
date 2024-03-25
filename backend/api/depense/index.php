<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : depense/index.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

header('Content-type: application/json; charset=utf-8');

require_once("../php/constantes.php");
require_once("../php/fonction.php");
require_once("../../../vendor/autoload.php");
require_once("../../secret.php");

use Projet\Budgetmanager\api\php\controller\SalaireCtrl; // Salaire : ~
use Projet\Budgetmanager\api\php\controller\GroupeCtrl; // Budget :
use Projet\Budgetmanager\api\php\controller\DepenseCtrl; // Depense +
use Projet\Budgetmanager\api\php\controller\CategorieCtrl; // Catégorie :

$error = [];
$salaireCtrl = new SalaireCtrl();
$groupeCtrl = new GroupeCtrl();
$depenseCtrl = new DepenseCtrl();
$categorieCtrl = new CategorieCtrl();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    // Salaire
    $idUtilisateur = 0;
    // Budget
    $idGroupe = 0;
    
    $idUtilisateur = filter_input(INPUT_GET, "idUtilisateur", FILTER_VALIDATE_INT);
    $idGroupe = filter_input(INPUT_GET, "idGroupe", FILTER_VALIDATE_INT);

    $salaire = $salaireCtrl->readSalaire($idUtilisateur);
    echo(json_encode($salaire));

    $budget = $groupeCtrl->getGroupe($idGroupe);
    echo(json_encode($budget));

    $categorie = $categorieCtrl->readAllCategorie();
    echo(json_encode($categorie));
}
else if($_SERVER["REQUEST_METHOD"] == "PUT"){
    // Salaire
    $id = 0;
    $somme = 0;
    $moisSalaire = "";
    $idUtilisateur = 0;
    // Données
    $donnees = recuperDonner();

    $id = array_key_exists("id", $donnees) ? filter_var($donnees["id"], FILTER_VALIDATE_INT) : null;
    $somme = array_key_exists("somme", $donnees) ? filter_var($donnees["somme"], FILTER_VALIDATE_INT) : null;
    $moisSalaire = array_key_exists("moisSalaire", $donnees) ? filter_var($donnees["moisSalaire"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $idUtilisateur = array_key_exists("idUtilisateur", $donnees) ? filter_var($donnees["idUtilisateur"], FILTER_VALIDATE_INT) : null;

    if($somme != null && $moisSalaire !== null  && $id !== null  && $idUtilisateur !== null){

        $salaire = $salaireCtrl->updateSalaire($id, $somme, $moisSalaire, $idUtilisateur);
        echo(json_encode($salaire));
        http_response_code(SERVEUR_PROBLEME);
        die();
    }
}
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $idDepense = 0;
    $nomDepense = "";
    $montant = 0;
    $date = "";
    $idCategorie = 0;
    $idUtilisateur = 0;
    // Categorie
    $nomCategorie = "";
    // Données
    $donnees = recuperDonner();

    var_dump($donnees);

    $nomDepense = array_key_exists("nomDepense", $donnees) ? filter_var($donnees["nomDepense"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $montant = array_key_exists("montant", $donnees) ? filter_var($donnees["montant"], FILTER_VALIDATE_INT) : null;
    $date = array_key_exists("date", $donnees) ? filter_var($donnees["date"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $idCategorie = array_key_exists("idCategorie", $donnees) ? filter_var($donnees["idCategorie"], FILTER_VALIDATE_INT) : null;
    $idUtilisateur = array_key_exists("idUtilisateur", $donnees) ? filter_var($donnees["idUtilisateur"], FILTER_VALIDATE_INT) : null;

    if($nomDepense !== null && $montant != null && $date != null && $idCategorie != null && $idUtilisateur != null)
    {

        $depense = $depenseCtrl->createDepense($nomDepense, $montant, $date, $idCategorie, $idUtilisateur);
        var_dump($depense);

        echo(json_encode($depense));

        if(is_array($depense))
        {
            http_response_code(INCOMPLET);
            die();
        }
        else
        {
            http_response_code(MODIFIE_RESSOURCE);
            die();
        }
    }

}
else
{
    http_response_code(SERVEUR_PROBLEME);
    die();
}