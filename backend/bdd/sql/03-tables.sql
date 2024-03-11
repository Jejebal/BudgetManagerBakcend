-- Project      : Budget Manager
-- Description  : Une application de gestion de budget et de dépenses monétaire.
-- File         : backend/bdd/sql/03-tables.sql
-- Authors      : Jérémy Ballanfat, Illya Nuzhny
-- Date         : 16 Février 2024

USE budget_manager;

-- ---------------------------------------------------------------
-- Tables principale
-- ---------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Utilisateur (
	id_utilisateur INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    nom_utilisateur VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) UNIQUE NULL,
    mot_passe VARCHAR(256) NOT NULL,
    remediation INT(2) NOT NULL,
    id_groupe INT NOT NULL,
    id_role INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Groupe (
	id_groupe INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    impots DOUBLE NOT NULL,
    loyer DOUBLE NOT NULL,
    credit DOUBLE NOT NULL,
    mois_budget DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS Role (
	id_role INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    nom_role VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Salaire (
	id_salaire INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    somme DOUBLE NOT NULL,
    mois_salaire DATE NOT NULL,
    id_utilisateur INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Categorie (
	id_categorie INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    nom_categorie VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Depense (
	id_depense INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    nom_depense VARCHAR(100) NOT NULL,
    montant DOUBLE NOT NULL,
    date DATE NOT NULL,
    id_categorie INT NOT NULL,
    id_utilisateur INT NOT NULL
);