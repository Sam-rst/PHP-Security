-- Création de la base de données (si elle n'existe pas déjà)
CREATE DATABASE IF NOT EXISTS Php_Secure_Paul;

-- Utilisation de la base de données
USE Php_Secure_Paul;

-- Création de la table pour stocker les informations du formulaire
CREATE TABLE IF NOT EXISTS formulaire_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    birthday DATE NOT NULL,
    description TEXT,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
