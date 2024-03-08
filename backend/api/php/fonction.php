<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : fonction.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

function recuperDonner() : array{

    $chaine = file_get_contents('php://input');
    if(!$chaine){

        return[];

    }

    $tableau = json_decode($chaine, true);

    if(!is_array($tableau)){

        return[];
    
    }

    return $tableau;

}