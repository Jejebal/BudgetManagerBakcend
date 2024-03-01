-- Project      : Budget Manager
-- Description  : Une application de gestion de budget et de dépenses monétaire.
-- File         : backend/bdd/sql/04-constrainte.sql
-- Authors      : Jérémy Ballanfat, Illya Nuzhny
-- Date         : 16 Février 2024

USE budget_manager;

-- ----------------------------------------------
-- Contraintes
-- ----------------------------------------------

ALTER TABLE Utilisateur
ADD CONSTRAINT fk_utilisateur_groupe
FOREIGN KEY (id_groupe)
REFERENCES Groupe(id_groupe),
ADD CONSTRAINT fk_utilisateur_role
FOREIGN KEY (id_role)
REFERENCES Role(id_role);

ALTER TABLE Salaire
ADD CONSTRAINT fk_salaire_utilisateur
FOREIGN KEY (id_utilisateur)
REFERENCES Utilisateur(id_utilisateur);

ALTER TABLE Depense
ADD CONSTRAINT fk_depense_groupe
FOREIGN KEY (id_categorie)
REFERENCES Categorie(id_categorie);