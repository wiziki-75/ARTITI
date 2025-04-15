<?php

// 🔹 Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: index.php?page=connexion");
    exit();
}

// 🔹 Récupération des informations utilisateur
$email = $_SESSION['email'] ?? 'Non défini';
$role = $_SESSION['role'] ?? 'Utilisateur';
$id_user = $_SESSION['user_id'] ?? 0;

$message = "";

// 🔹 Gestion de l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_produit'], $_POST['prix_unitaire'])) {
    $id_produit = $_POST['id_produit'];
    $prix_unitaire = $_POST['prix_unitaire'];
    
    $ajoutReussi = $unControleur->addToPanier($id_user, $id_produit, 1, $prix_unitaire);
    $message = $ajoutReussi ? "Produit ajouté au panier !" : "Erreur lors de l'ajout au panier.";
}

// 🔹 Gestion de la commande
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commander'])) {
    $panier = $unControleur->getPanierByUser($id_user);

    if (empty($panier)) {
        $message = "Votre panier est vide. Ajoutez des produits avant de commander.";
    } else {
        $total = 0;
        foreach ($panier as $item) {
            $total += $item['quantite'] * $item['prix_unitaire'];
        }

        $id_commande = $unControleur->createCommande($id_user, $total, $panier);
        if ($id_commande) {
            $message = "Commande validée avec succès !";
        } else {
            $message = "Erreur lors de la validation de la commande.";
        }
    }
}

// 🔹 Récupérer les produits et le panier
$produits = $unControleur->getAllProduits();
$panier = $unControleur->getPanierByUser($id_user);
$total_articles = 0;
$total_prix = 0;

foreach ($panier as $item) {
    $total_articles += $item['quantite'];
    $total_prix += $item['quantite'] * $item['prix_unitaire'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Liste des Produits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Bienvenue sur votre espace</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Informations de connexion</h5>
                <p><strong>Email :</strong> <?= htmlspecialchars($email) ?></p>
                <p><strong>Rôle :</strong> <?= htmlspecialchars($role) ?></p>
            </div>
        </div>

        <!-- Boutons de navigation -->
        <a href="index.php?page=passer_vendeur" class="btn btn-primary mt-4">Passer vendeur</a>
        <a href="index.php?page=ajouter_produit" class="btn btn-primary mt-4">Ajouter un produit</a>
        <a href="index.php?page=ajouter_adresse" class="btn btn-primary mt-4">Ajouter une adresse</a>
        <a href="index.php?page=voir_commandes" class="btn btn-primary mt-4">Voir les commandes</a>
        <a href="index.php?page=deconnexion" class="btn btn-danger mt-4">Se déconnecter</a>

        <!-- Affichage du Panier -->
        <div class="alert alert-info mt-4">
            🛒 <strong>Panier :</strong> <?= $total_articles ?> article(s) - Total : <?= number_format($total_prix, 2) ?> €
        </div>

        <!-- Bouton Commander -->
        <?php if ($total_articles > 0) : ?>
            <form method="post">
                <button type="submit" name="commander" class="btn btn-success">Commander</button>
            </form>
        <?php endif; ?>

        <?php if (isset($message) && $message !== "") : ?>
            <div class="alert alert-success mt-3"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Liste des Produits -->
        <h2 class="mt-4">Liste des Produits</h2>

        <?php if (!empty($produits)) : ?>
            <table class="table table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix (€)</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit) : ?>
                        <tr>
                            <td><?= htmlspecialchars($produit['id_produit']) ?></td>
                            <td><?= htmlspecialchars($produit['nom']) ?></td>
                            <td><?= number_format($produit['prix'], 2) ?> €</td>
                            <td><?= htmlspecialchars($produit['type']) ?></td>
                            <td><?= htmlspecialchars($produit['quantite']) ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id_produit" value="<?= $produit['id_produit'] ?>">
                                    <input type="hidden" name="prix_unitaire" value="<?= $produit['prix'] ?>">
                                    <button type="submit" class="btn btn-success">Ajouter au Panier</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-warning">Aucun produit disponible pour le moment.</div>
        <?php endif; ?>
    </div>
</body>
</html>
