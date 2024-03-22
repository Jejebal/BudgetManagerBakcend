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

use Projet\Budgetmanager\api\php\controller\UserCtrl;
use Projet\Budgetmanager\api\php\controller\GroupeCtrl;

$error = [];
$userCtrl = new UserCtrl();
$groupeCtrl = new GroupeCtrl();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nom = "";
    $email = "";
    $motPasse = "";
    $remediation = "";
    $idGroupe = "";

    $donnees = recuperDonner();

    $nom = array_key_exists("nom", $donnees) ? filter_var($donnees["nom"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $email = array_key_exists("email", $donnees) ? filter_var($donnees["email"], FILTER_VALIDATE_EMAIL) : null;
    $motPasse = array_key_exists("motPasse", $donnees) ? filter_var($donnees["motPasse"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $remediation = array_key_exists("remediation", $donnees) ? filter_var($donnees["remediation"], FILTER_VALIDATE_INT) : null;
    $idGroupe = array_key_exists("idGroupe", $donnees) ? filter_var($donnees["idGroupe"], FILTER_VALIDATE_INT) : null;

    if($nom != null && $email == null && $motPasse != null && $remediation == null && $idGroupe == null){

        $user = $userCtrl->checkLogin($nom, $motPasse);

        echo(json_encode($user));

        if(is_array($user)){

            http_response_code(INCOMPLET);
            die();

        }
        else{

            http_response_code(RETOURNE_INFORMATION);
            die();

        }

    }
    else if($nom != null && $email == null && $motPasse != null && $remediation != null && $idGroupe != null){

        $user = $userCtrl->createMember($nom, $motPasse, $remediation, $idGroupe);

        echo(json_encode($user));

        if(is_array($user)){

            http_response_code(INCOMPLET);
            die();

        }
        else{

            http_response_code(CREE_RESSOURCE);
            die();

        }

    }
    else {

        $groupeId = $groupeCtrl->createGroupe();

        if(is_array($groupeId)){

            echo(json_encode($groupeId));
            http_response_code(SERVEUR_PROBLEME);
            die();

        }
        else{

            $user = $userCtrl->createAdmin($nom, $email, $motPasse, $remediation, $groupeId);

            echo(json_encode($user));

            if(is_array($user)){

                http_response_code(INCOMPLET);
                die();

            }
            else{

                http_response_code(CREE_RESSOURCE);
                die();

            }

        }

    }

}
else{

    http_response_code(SERVEUR_PROBLEME);
    die();

}