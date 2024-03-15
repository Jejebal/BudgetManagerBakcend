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

 namespace Projet\Budgetmanager\api\php\model;

use Projet\Budgetmanager\api\php\model\Database;

class BaseModel {

    /** List des noms de la base de données dans les noms php */

    protected $map = [];

    /**
     * 
     * Vérifie que $name existe dans $map et le change sous la forme php
     * 
     * @param string $name le nom de la variable
     * @param string $value la valeur qui est essayez d'être ajouter
     * 
     */
    public function __set($name, $value): void
    {
        
        if(array_key_exists($name, $this->map)){

            $name = $this->map[$name];

        }

        $this->$name = $value;

    }

}