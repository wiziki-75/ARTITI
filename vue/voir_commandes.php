<?php
// 🔹 Vérifier si l'utilisateur est connecté et est client
// if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'client') {
//     header("Location: index.php?page=connexion");
//     exit();
// }

if (isset($_POST['delete_detail'])) {
    $idDetail = $_POST['id_detail'];
    $unControleur->deleteDetailCommande($idDetail);

    // Recalculer le total après suppression
    $idCommande = $_POST['id_commande'];
    $unControleur->recalculerTotalCommande($idCommande);
}


$id_user = $_SESSION['user_id']; // ID du client connecté

// 🔹 Récupérer les commandes du client
$commandes = $unControleur->getCommandesByUser($id_user);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Mes Commandes</h2>
        <?php if (empty($commandes)) : ?>
            <p>Aucune commande trouvée.</p>
        <?php else : ?>
            <?php foreach ($commandes as $commande) : ?>
                <div class="card mb-4">
                    <div class="card-header">
                        Commande #<?= $commande['id_commande'] ?> - <?= $commande['statut'] ?> - <?= $commande['date_commande'] ?>
                    </div>
                    <div class="card-body">
                    <ul class="list-group">
                            <?php
                            $details = $unControleur->getDetailsCommande($commande['id_commande']);
                            foreach ($details as $detail) :
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <?= htmlspecialchars($detail['nom']) ?> (x<?= $detail['quantite'] ?>)
                                        <span class="text-muted ms-2"><?= number_format($detail['prix_unitaire'], 2, ',', ' ') ?> €</span>
                                    </div>
                                    <form method="post" style="margin: 0;">
                                    <input type="hidden" name="id_detail" value="<?= $detail['id_details'] ?>">
                                    <input type="hidden" name="id_commande" value="<?= $commande['id_commande'] ?>">
                                    <button type="submit" name="delete_detail" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet article ?')">
                                        🗑️
                                    </button>
                                </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="mt-3">
                            <strong>Total : <?= number_format($commande['total'], 2, ',', ' ') ?> €</strong>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <a href="index.php?page=home" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
</body>
</html>
