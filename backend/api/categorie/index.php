<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : depense/index.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 7 avril 2024
 * 
 */

header('Content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once("../php/constantes.php");
require_once("../php/fonction.php");
require_once("../../../vendor/autoload.php");
require_once("../../secret.php");

use Projet\Budgetmanager\api\php\controller\CategorieCtrl;

$error = [];
$categorieCtrl = new CategorieCtrl();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    $categories = $categorieCtrl->readAllCategorie();

    if(is_array($categorieCtrl)){

        echo(json_encode(["error" => $categories]));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }
    else{

        echo(json_encode($categories));
        http_response_code(RETOURNE_INFORMATION);
        die();

    }

}
else
{

    http_response_code(RETOURNE_INFORMATION);
    die();

}