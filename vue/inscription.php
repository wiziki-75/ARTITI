<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // 🔹 Vérifications
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse e-mail n'est pas valide.";
    } elseif ($password !== $confirm_password) {
        $message = "Les mots de passe ne correspondent pas.";
    } elseif ($unControleur->emailExists($email)) {
        $message = "Cet email est déjà utilisé.";
    } else {
        // 🔹 Création de l'utilisateur via le contrôleur
        if ($unControleur->createUser($nom, $prenom, $email, $password)) {
            $message = "Inscription réussie ! <a href='login.php'>Connectez-vous ici</a>.";
        } else {
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>

<div class="container mt-5">
    <h2>Inscription</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <p class="mt-3">Déjà un compte ? <a href="index.php?page=connexion">Se connecter</a></p>
</div>