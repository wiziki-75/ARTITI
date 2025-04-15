<?php
if (!isset($_SESSION['id'])) {
    echo "<div class='alert alert-warning'>Veuillez vous connecter pour voir votre panier.</div>";
    return;
}

$id_user = $_SESSION['id'];
$message = null;

// 🔸 Suppression d'un produit (décrément ou suppression complète)
if (isset($_POST['supprimer_produit']) && isset($_POST['id_produit'])) {
    $id_produit = $_POST['id_produit'];
    foreach ($unControleur->getPanierByUser($id_user) as $item) {
        if ($item['id_produit'] == $id_produit) {
            if ($item['quantite'] > 1) {
                $unControleur->updatePanier($id_user, $id_produit, $item['quantite'] - 1);
            } else {
                $unControleur->deleteFromPanier($id_user, $id_produit);
            }
            break;
        }
    }
}

// 🔸 Passage de commande
if (isset($_POST['passer_commande'])) {
    $panier = $unControleur->getPanierByUser($id_user);

    if (!empty($panier)) {
        $total = 0;
        $panierDetails = [];

        foreach ($panier as $item) {
            $total += $item['quantite'] * $item['prix_unitaire'];
            $panierDetails[] = [
                'id_produit' => $item['id_produit'],
                'quantite' => $item['quantite'],
                'prix_unitaire' => $item['prix_unitaire']
            ];
        }

        // Création de la commande
        $commandeId = $unControleur->createCommande($id_user, $total, $panierDetails);

        if ($commandeId) {
            $message = "<div class='alert alert-success'>Commande #$commandeId validée avec succès !</div>";
        } else {
            $message = "<div class='alert alert-danger'>Une erreur est survenue lors de la commande.</div>";
        }
    }
}

// 🔸 Récupération du panier (après suppression ou commande)
$panier = $unControleur->getPanierByUser($id_user);
$total = 0;
?>

<div class="container mt-5">
    <h2 class="mb-4">Mon panier</h2>
    <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>

    <?= $message ?? '' ?>

    <?php if (empty($panier)): ?>
        <div class="alert alert-info">Votre panier est vide.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($panier as $item): 
                    $sousTotal = $item['quantite'] * $item['prix_unitaire'];
                    $total += $sousTotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nom']) ?></td>
                        <td><?= $item['quantite'] ?></td>
                        <td><?= number_format($item['prix_unitaire'], 2) ?> €</td>
                        <td><?= number_format($sousTotal, 2) ?> €</td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Supprimer un exemplaire de ce produit ?');">
                                <input type="hidden" name="id_produit" value="<?= $item['id_produit'] ?>">
                                <button type="submit" name="supprimer_produit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total :</strong></td>
                    <td colspan="2"><strong><?= number_format($total, 2) ?> €</strong></td>
                </tr>
            </tbody>
        </table>

        <form method="POST">
            <button type="submit" name="passer_commande" class="btn btn-success">Passer la commande</button>
        </form>
    <?php endif; ?>
</div>
