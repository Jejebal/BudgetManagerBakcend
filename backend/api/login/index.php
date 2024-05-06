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
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once("../php/constantes.php");
require_once("../php/fonction.php");
require_once("../../../vendor/autoload.php");
require_once("../../secret.php");

use Projet\Budgetmanager\api\php\controller\UserCtrl;

$error = [];
$userCtrl = new UserCtrl();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nom = "";
    $motPasse = "";

    $donnees = recuperDonner();

    $nom = array_key_exists("nomUtilisateur", $donnees) ? filter_var($donnees["nomUtilisateur"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $motPasse = array_key_exists("motPasse", $donnees) ? filter_var($donnees["motPasse"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

    $user = $userCtrl->checkLogin($nom, $motPasse);

    if(is_array($user)){

        echo(json_encode(["error" => $user]));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }
    else{
        
        echo(json_encode($user));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }

}
else{

    http_response_code(RETOURNE_INFORMATION);
    die();

}