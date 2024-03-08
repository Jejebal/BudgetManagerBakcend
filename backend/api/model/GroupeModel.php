<?php

/**
 * 
 * Project : Budget manager
 * Description : Une application de gestion de budget et de dépenses monétaire.
 * File : BaseModel.php
 * Authors : Jérémy Ballanfat, Illya Nuzhny
 * Date : 8 mars 2024
 * 
 */

namespace Projet\Budgetmanager\model;

use Projet\Budgetmanager\model\BaseModel as BaseModel;

class GroupeModel extends BaseModel {

    protected $map = [

        "id_groupe" => "idGroupe",
        "impots" => "impots",
        "loyer" => "loyer",
        "credit" => "credit",
        "mois_budget" => "moisBudget"

    ];

    public int $impots;

}