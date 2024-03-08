-- Project      : Budget Manager
-- Description  : Une application de gestion de budget et de dépenses monétaire.
-- File         : backend/bdd/sql/05-data.sql
-- Authors      : Jérémy Ballanfat, Illya Nuzhny
-- Date         : 16 Février 2024

USE budget_manager;

-- ----------------------------------------------
-- Data
-- ----------------------------------------------

INSERT INTO Role (nom_role)
VALUES('Utilisateur'), ('Administrateur');

INSERT INTO Categorie (nom_categorie)
VALUES('Alimentaire'), ('Restoration'), ('Voyage'), ('Plaisir'), ('Consommables'), ('Cadeaux');