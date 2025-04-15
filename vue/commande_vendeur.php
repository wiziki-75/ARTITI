<?php
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'vendeur') {
    header("Location: index.php?page=connexion");
    exit();
}

// 🔹 Traitement de la mise à jour du statut
if (isset($_POST['update_statut'])) {
    $unControleur->updateStatutCommande($_POST['id_commande'], $_POST['statut']);
}

// 🔹 Commande sélectionnée pour voir les détails
$idCommandeSelectionnee = isset($_POST['voir_details']) ? $_POST['id_commande'] : null;

// 🔹 Récupération de toutes les commandes
$commandes = $unControleur->getAllCommandes();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des commandes</h2>
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?= $commande['id_commande'] ?></td>
                    <td><?= htmlspecialchars($commande['prenom'] . ' ' . $commande['nom']) ?></td>
                    <td><?= htmlspecialchars($commande['email']) ?></td>
                    <td><?= number_format($commande['total'], 2) ?> €</td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($commande['statut']) ?></span></td>
                    <td><?= $commande['date_commande'] ?></td>
                    <td class="d-flex gap-2">
                        <!-- 🔸 Formulaire de modification de statut -->
                        <form method="POST" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="id_commande" value="<?= $commande['id_commande'] ?>">
                            <select name="statut" class="form-select form-select-sm">
                                <option value="en attente" <?= $commande['statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="payée" <?= $commande['statut'] == 'payée' ? 'selected' : '' ?>>Payée</option>
                                <option value="expédiée" <?= $commande['statut'] == 'expédiée' ? 'selected' : '' ?>>Expédiée</option>
                                <option value="livrée" <?= $commande['statut'] == 'livrée' ? 'selected' : '' ?>>Livrée</option>
                                <option value="annulée" <?= $commande['statut'] == 'annulée' ? 'selected' : '' ?>>Annulée</option>
                            </select>
                            <button type="submit" name="update_statut" class="btn btn-sm btn-outline-success">✔</button>
                        </form>

                        <!-- 🔸 Formulaire pour voir les détails -->
                        <form method="POST">
                            <input type="hidden" name="id_commande" value="<?= $commande['id_commande'] ?>">
                            <button type="submit" name="voir_details" class="btn btn-sm btn-outline-info">Voir détails</button>
                        </form>
                    </td>
                </tr>

                <!-- 🔸 Affichage des détails de la commande sélectionnée -->
                <?php if ($idCommandeSelectionnee == $commande['id_commande']): 
                    $details = $unControleur->getDetailsCommande($commande['id_commande']);
                ?>
                    <tr>
                        <td colspan="7">
                            <div class="card card-body">
                                <h5>Détails de la commande #<?= $commande['id_commande'] ?> :</h5>
                                <table class="table table-sm table-bordered mt-2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produit</th>
                                            <th>Quantité</th>
                                            <th>Prix unitaire</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($details as $item): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['nom']) ?></td>
                                                <td><?= $item['quantite'] ?></td>
                                                <td><?= number_format($item['prix_unitaire'], 2) ?> €</td>
                                                <td><?= number_format($item['quantite'] * $item['prix_unitaire'], 2) ?> €</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
