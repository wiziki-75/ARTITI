CREATE DATABASE artiti;
USE artiti;

CREATE TABLE User (
    id_user INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('client', 'vendeur', 'admin') NOT NULL DEFAULT 'client',
    mot_de_passe VARCHAR(255) NOT NULL,
    derniere_connexion DATETIME NULL
);

CREATE TABLE Adresse (
    id_adresse INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    nom VARCHAR(255) NOT NULL,
    code_postal VARCHAR(10) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NULL,
    FOREIGN KEY (id_user) REFERENCES User(id_user) ON DELETE CASCADE
);

CREATE TABLE Commerce (
    id_commerce INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    description TEXT NULL,
    siret VARCHAR(14) NULL,
    adresse VARCHAR(255) NOT NULL,
    code_postal VARCHAR(10) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NULL,
    site_web VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES User(id_user) ON DELETE CASCADE
);

CREATE TABLE Produit (
    id_produit INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    vendeur INT UNSIGNED NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    type VARCHAR(50) NOT NULL,
    FOREIGN KEY (vendeur) REFERENCES User(id_user) ON DELETE CASCADE
);

CREATE TABLE Panier (
    id_panier INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    id_produit INT UNSIGNED NOT NULL,
    quantite INT UNSIGNED DEFAULT 1,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES User(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES Produit(id_produit) ON DELETE CASCADE
);

CREATE TABLE Commandes (
    id_commande INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    statut ENUM('en attente', 'payée', 'expédiée', 'livrée', 'annulée') DEFAULT 'en attente',
    total DECIMAL(10,2) NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES User(id_user) ON DELETE CASCADE
);

CREATE TABLE Details_commande (
    id_details INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_commande INT UNSIGNED NOT NULL,
    id_produit INT UNSIGNED NOT NULL,
    quantite INT UNSIGNED DEFAULT 1,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_commande) REFERENCES Commandes(id_commande) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES Produit(id_produit) ON DELETE CASCADE
);

