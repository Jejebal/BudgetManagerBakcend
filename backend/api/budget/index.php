<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : budget/index.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 22 mars 2024
 * 
 */

header('Content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once("../php/constantes.php");
require_once("../php/fonction.php");
require_once("../../../vendor/autoload.php");
require_once("../../secret.php");

use Projet\Budgetmanager\api\php\controller\GroupeCtrl;

$error = [];

$groupeCtrl = new GroupeCtrl();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    $idGroupe = 0;

    $idGroupe = filter_input(INPUT_GET, "idGroupe", FILTER_VALIDATE_INT);

    $group = $groupeCtrl->getGroupe($idGroupe);

    echo(json_encode($group));

    if(is_array($group)){

        http_response_code(RESSOURCE_INTROUVABLE);
        die();

    }
    else{

        http_response_code(RETOURNE_INFORMATION);
        die();

    }

}
else if($_SERVER["REQUEST_METHOD"] == "PUT"){

    $idGroupe = 0;
    $impot = 0.0;
    $loyer = 0.0;
    $credits = 0.0;
    $moisBudget = "";

    $donnees = recuperDonner();

    $idGroupe = filter_input(INPUT_GET, "idGroupe", FILTER_VALIDATE_INT);
    $impot = array_key_exists("impot", $donnees) ? filter_var($donnees["impot"], FILTER_VALIDATE_FLOAT) : null;
    $loyer = array_key_exists("loyer", $donnees) ? filter_var($donnees["loyer"], FILTER_VALIDATE_FLOAT) : null;
    $credits = array_key_exists("credits", $donnees) ? filter_var($donnees["credits"], FILTER_VALIDATE_FLOAT) : null;
    $moisBudget = array_key_exists("moisBudget", $donnees) ? filter_var($donnees["moisBudget"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

    $groupe = $groupeCtrl->modifieGroup($idGroupe, $impot, $loyer, $credits, $moisBudget);

    if(is_array($groupe)){

        echo(json_encode(["error" => $groupe]));
        http_response_code(INCOMPLET);
        die();

    }
    else{

        echo(json_encode($groupe));
        http_response_code(MODIFIE_RESSOURCE);
        die();

    }

}
else{

    http_response_code(SERVEUR_PROBLEME);
    die();

}