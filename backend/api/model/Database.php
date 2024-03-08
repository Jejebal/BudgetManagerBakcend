<?php

/**
 * 
 * Project : Science scope
 * Description : Un site permutant de faire passer des questionnaires a des élève et créer des questionnaires.
 * File : BaseModel.php
 * Authors : Jérémy Ballanfat, Kajan Muthuligam, Jamal Saeed
 * Date : 7 mars 2024
 * 
 */

namespace Projet\Sciencescope\model;

use PDOStatement;

require_once("../secret.php");

class Database {

    /**
     * Le singleton de la classe Database
     */
    private static ?Database   $instance = null;

    /**
     * La variable pour accéder à la base de données
     */
    private \PDO $pdo;

    /**
     * Obtenir l'instance de la classe Database
     */
    public static function getDB() : Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Constructeur de la classe d'accès à la base de données
     */
    private function __construct()
    {
        $dsn = "mysql:host=".BDD_HOTE.";dbname=".BDD_NOM.";charset=".BDD_CHARSET;
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];

        $this->pdo = new \PDO($dsn, BDD_UTILISATEUR, BDD_MOT_DE_PASSE, $opt);
    }

    /**
     * 
     * Retourne le pdo de la base de données.
     * 
     */
    public static function getPdo() {

        return self::getDB()->pdo;

      }

    /**
     * Exécuter une requête sur la base de données connectée
     * 
     * @param string $query - La requête SQL
     * @param array  $param - les paramètres pour la requête
     * 
     * @return PDOStatement Le résultat de l'exécution de la requête
     */
    public function run($query, $param = [])
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($param);
        return $statement;
    }

    /**
     * Permet d'obtenir l'identifiant de la dernière insertion
     * @return string|false Une chaîne avec l'identifiant ou false en cas d'erreur
     */
    public function lastInsertId() : string|false
    {
        return $this->pdo->lastInsertId();
    }
}
