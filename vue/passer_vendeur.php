<?php
// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: index.php?page=connexion");
    exit();
}

// Vérification si l'utilisateur est déjà vendeur
if ($_SESSION['role'] === 'vendeur') {
    header("Location: index.php?page=home");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = trim($_POST['description']);
    $siret = trim($_POST['siret']);
    $adresse = trim($_POST['adresse']);
    $code_postal = trim($_POST['code_postal']);
    $ville = trim($_POST['ville']);
    $telephone = trim($_POST['telephone']);
    $site_web = trim($_POST['site_web']);
    $email_contact = trim($_POST['email_contact']);

    // Vérifications de base
    if (empty($description) || empty($siret) || empty($adresse) || empty($code_postal) || empty($ville) || empty($telephone) || empty($email_contact)) {
        $message = "Tous les champs obligatoires doivent être remplis.";
    } else {
        // Création du commerce
        $id_user = $_SESSION['user_id'];
        $commerceCree = $unControleur->createCommerce($id_user, $description, $siret, $adresse, $code_postal, $ville, $telephone, $site_web, $email_contact);

        if ($commerceCree) {
            // 🔹 Mise à jour du rôle utilisateur via `updateUserRole`
            if ($unControleur->updateUserRole($id_user, 'vendeur')) {
                $_SESSION['role'] = 'vendeur'; // Met à jour le rôle en session

                // 🔹 Redirection vers home
                header("Location: index.php?page=home");
                exit();
            } else {
                $message = "Erreur lors de la mise à jour du rôle.";
            }
        } else {
            $message = "Erreur lors de la création du commerce.";
        }
    }
}
?>

<div class="container mt-5">
    <h2>Devenir Vendeur</h2>
    <form method="post">
        <div class="mb-3">
            <label>Description de votre commerce</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Numéro SIRET</label>
            <input type="text" name="siret" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Code Postal</label>
            <input type="text" name="code_postal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ville</label>
            <input type="text" name="ville" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Site Web (optionnel)</label>
            <input type="text" name="site_web" class="form-control">
        </div>
        <div class="mb-3">
            <label>Email de Contact</label>
            <input type="email" name="email_contact" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Valider</button>
    </form>
    <p class="mt-3"><a href="index.php?page=home">Retour à l'accueil</a></p>
</div>