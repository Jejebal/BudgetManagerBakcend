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

use Projet\Budgetmanager\model\Database as Database;

class RoleModel extends BaseModel {

    protected $map = [

        "id_role" => "idRole",
        "nom_role" => "nomRole"

    ];

    public int $idRole;

    public string $nomRole;

}