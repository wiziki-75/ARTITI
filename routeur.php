<?php
session_start();
session_regenerate_id(true);

require_once("controleur/controleur.class.php");
$unControleur = new Controleur();

// 🔹 Déterminer la page demandée
$page = $_GET['page'] ?? 'home';

// 🔹 Si l'utilisateur n'est pas connecté, il peut uniquement aller sur inscription et connexion
$pages_accessibles_sans_connexion = ['inscription', 'connexion'];

if (!isset($_SESSION['email']) && !in_array($page, $pages_accessibles_sans_connexion)) {
    header("Location: index.php?page=inscription");
    exit();
}

// 🔹 Définition des routes
$routes = [
    'home' => "vue/home.php",
    'connexion' => "vue/connexion.php",  // ✅ Accessible si non connecté
    'profil' => isset($_SESSION['email']) ? "vue/profil.php" : "vue/non_connecte.php",
    'admin' => ($_SESSION['role'] ?? '') === 'organisateur' ? "vue/admin.php" : "vue/acces.php",
    'passer_vendeur' => isset($_SESSION['email']) ? "vue/passer_vendeur.php" : "vue/non_connecte.php",
    'ajouter_produit' => ($_SESSION['role'] ?? '') === 'vendeur' ? "vue/ajouter_produit.php" : "vue/acces.php",
    'inscription' => "vue/inscription.php",  // ✅ Page d'inscription obligatoire
    'deconnexion' => "deconnexion.php"
];

// 🔹 Gestion de la déconnexion
if ($page === 'deconnexion') {
    session_destroy();
    unset($_SESSION);
    header("Location: index.php?page=inscription");
    exit();
}

// 🔹 Charger la bonne page
require_once($routes[$page] ?? "vue/inscription.php");
