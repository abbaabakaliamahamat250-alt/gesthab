-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gesthab_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gesthab_db;

-- Structure de la table pour les demandes d'habilitation
CREATE TABLE IF NOT EXISTS demandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,           -- L'ID de celui qui fait la demande
    objet VARCHAR(255) NOT NULL,    -- Le titre ou l'objet de l'habilitation
    description TEXT,               -- Détails de la demande
    status ENUM('pending', 'validated', 'rejected') DEFAULT 'pending',
    current_step INT DEFAULT 1,     -- Étape actuelle (1, 2 ou 3)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertion de quelques données de test pour vérifier la récupération
INSERT INTO demandes (user_id, objet, description, current_step) VALUES 
(101, 'Accès Serveur SSH', 'Demande pour participer au projet', 1),
(102, 'Accès Base de données', 'Besoin de droits en lecture', 1),
(103, 'Badge Entrée', 'Accès aux locaux techniques', 2);