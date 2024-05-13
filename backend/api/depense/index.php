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
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

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
    $budget = $groupeCtrl->getGroupe($idGroupe);

    $list = [ 

        "salaire" => $salaire,
        "budget" => $budget

    ];

    if(is_array($salaire) || is_array($budget)){

        echo(json_encode(["error" => $list]));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }
    else{

        echo(json_encode($list));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }

}
else if($_SERVER["REQUEST_METHOD"] == "PUT"){
    // Salaire
    $somme = 0.0;
    $moisSalaire = "";
    $idUtilisateur = 0;
    // Données
    $donnees = recuperDonner();

    $idUtilisateur = filter_input(INPUT_GET, "idUtilisateur", FILTER_VALIDATE_INT);
    $somme = array_key_exists("somme", $donnees) ? filter_var($donnees["somme"], FILTER_VALIDATE_FLOAT) : null;
    $moisSalaire = array_key_exists("moisSalaire", $donnees) ? filter_var($donnees["moisSalaire"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

    $salaire = $salaireCtrl->updateSalaire($somme, $moisSalaire, $idUtilisateur);

    if(is_array($salaire))
    {

        echo(json_encode(["error" => $salaire]));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }
    else
    {

        echo(json_encode($salaire));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }

}
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $nomDepense = "";
    $montant = 0;
    $idCategorie = 0;
    $idUtilisateur = 0;

    // Categorie
    $nomCategorie = "";

    // Données
    $donnees = recuperDonner();

    $nomDepense = array_key_exists("nomDepense", $donnees) ? filter_var($donnees["nomDepense"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $montant = array_key_exists("montant", $donnees) ? filter_var($donnees["montant"], FILTER_VALIDATE_FLOAT) : null;
    $idCategorie = array_key_exists("idCategorie", $donnees) ? filter_var($donnees["idCategorie"], FILTER_VALIDATE_INT) : null;
    $idUtilisateur = array_key_exists("idUtilisateur", $donnees) ? filter_var($donnees["idUtilisateur"], FILTER_VALIDATE_INT) : null;

    $depense = $depenseCtrl->createDepense($nomDepense, $montant, $idCategorie, $idUtilisateur);

    if(is_array($depense))
    {

        echo(json_encode(["error" => $depense]));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }
    else
    {
        
        echo(json_encode($depense));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }

}
else
{

    http_response_code(RETOURNE_INFORMATION);
    die();

}