<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : historique/index.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 4 avril 2024
 * 
 */

header('Content-type: application/json; charset=utf-8');

require_once("../php/constantes.php");
require_once("../php/fonction.php");
require_once("../../../vendor/autoload.php");
require_once("../../secret.php");

use Projet\Budgetmanager\api\php\controller\HistoriqueCtrl;

$error = [];
$historiqueCtrl = new HistoriqueCtrl();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    $idGroupe = 0;

    $idGroupe = filter_input(INPUT_GET, "idGroupe", FILTER_VALIDATE_INT);

    $historique = $historiqueCtrl->getAllHistorique($idGroupe);

    echo(json_encode($historique));

    if(array_key_exists("groupe", $historique) || array_key_exists("recuperation", $historique)){

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