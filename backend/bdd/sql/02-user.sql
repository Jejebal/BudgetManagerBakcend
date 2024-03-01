-- Project      : Budget Manager
-- Description  : Une application de gestion de budget et de dépenses monétaire.
-- File         : backend/bdd/sql/02-user.sql
-- Authors      : Jérémy Ballanfat, Illya Nuzhny
-- Date         : 16 Février 2024

USE budget_manager;

-- ---------------------------------------------------------------
-- User
-- ---------------------------------------------------------------

DROP USER IF EXISTS "budget_user"@"localhost";

CREATE USER "budget_user"@"localhost" IDENTIFIED BY "budget_super";

GRANT INSERT ON budget_manager.* TO "budget_user"@"localhost";
GRANT SELECT ON budget_manager.* TO "budget_user"@"localhost";
GRANT UPDATE ON budget_manager.* TO "budget_user"@"localhost";
GRANT DELETE ON budget_manager.* TO "budget_user"@"localhost";