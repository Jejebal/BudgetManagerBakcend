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
    id_groupe INT NOT NULL UNIQUE,
    id_role INT NOT NULL UNIQUE
);