<?php

// 🔹 Vérifier si l'utilisateur est connecté et est vendeur
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'vendeur') {
    header("Location: index.php?page=connexion");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prix = trim($_POST['prix']);
    $type = trim($_POST['type']);
    $quantite = trim($_POST['quantite']);

    // 🔹 Vérifications de base
    if (empty($nom) || empty($prix) || empty($type) || empty($quantite)) {
        $message = "Tous les champs doivent être remplis.";
    } elseif (!is_numeric($prix) || $prix <= 0) {
        $message = "Le prix doit être un nombre positif.";
    } elseif (!is_numeric($quantite) || $quantite < 0) {
        $message = "La quantité doit être un nombre positif.";
    } else {
        // 🔹 Ajouter le produit dans la base
        $vendeur = $_SESSION['user_id']; // ID du vendeur
        $ajoutReussi = $unControleur->addProduit($nom, $prix, $vendeur, $type, $quantite);

        if ($ajoutReussi) {
            $message = "Produit ajouté avec succès !";
        } else {
            $message = "Erreur lors de l'ajout du produit.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter un Produit</h2>
        <form method="post">
            <div class="mb-3">
                <label>Nom du Produit</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Prix (€)</label>
                <input type="text" name="prix" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Type de Produit</label>
                <select name="type" class="form-control" required>
                    <option value="">Sélectionnez un type</option>
                    <option value="Fruit">Fruit</option>
                    <option value="Légume">Légume</option>
                    <option value="Boisson">Boisson</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Quantité en Stock</label>
                <input type="number" name="quantite" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter le Produit</button>
        </form>
        <p class="mt-3"><a href="index.php?page=home">Retour à l'accueil</a></p>
    </div>
</body>
</html>
