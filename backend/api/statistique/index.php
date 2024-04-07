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

header('Content-type: application/json; charset=utf-8');

require_once("../php/constantes.php");
require_once("../php/fonction.php");
require_once("../../../vendor/autoload.php");
require_once("../../secret.php");

use Projet\Budgetmanager\api\php\controller\GroupeCtrl;
use Projet\Budgetmanager\api\php\controller\DepenseCtrl;
use Projet\Budgetmanager\api\php\controller\SalaireCtrl;

$error = [];
$salaireCtrl = new SalaireCtrl();
$groupeCtrl = new GroupeCtrl();
$depenseCtrl = new DepenseCtrl();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    $idUtilisateur = 0;
    $idGroupe = 0;
    $date = 0;
    
    $idUtilisateur = filter_input(INPUT_GET, "idUtilisateur", FILTER_VALIDATE_INT);
    $idGroupe = filter_input(INPUT_GET, "idGroupe", FILTER_VALIDATE_INT);

    $salaire = $salaireCtrl->readSalaire($idUtilisateur);
    $budget = $groupeCtrl->getGroupe($idGroupe);
    $depense = $depenseCtrl->readSumDepense($idUtilisateur);

    $list = [

        "salaire" => $salaire,
        "budget" => $budget,
        "depense" => round($depense, 2)

    ];

    echo(json_encode($list));

    if(is_array($salaire) || is_array($budget) || is_array($depense)){

        http_response_code(RESSOURCE_INTROUVABLE);
        die();

    }
    else{

        http_response_code(RETOURNE_INFORMATION);
        die();

    }

}
else{

    http_response_code(SERVEUR_PROBLEME);
    die();

}