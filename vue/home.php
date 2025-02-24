<?php

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: index.php?page=connexion");
    exit();
}

// Récupération des informations utilisateur
$email = $_SESSION['email'] ?? 'Non défini';
$role = $_SESSION['role'] ?? 'Utilisateur';
?>

<div class="container mt-5">
    <h2>Bienvenue sur votre espace</h2>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Informations de connexion</h5>
            <p><strong>Email :</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($role) ?></p>
        </div>
    </div>

    <!-- Bouton de déconnexion -->
    <a href="index.php?page=passer_vendeur" class="btn mt-4">Passer vendeur</a>
    <a href="index.php?page=deconnexion" class="btn btn-danger mt-4">Se déconnecter</a>
</div>