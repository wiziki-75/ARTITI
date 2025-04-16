<?php
// Toujours en tout premier
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔹 Vérifie si l'utilisateur est connecté et vendeur
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'vendeur') {
    header("Location: index.php?page=connexion");
    exit();
}

// 🔹 Traitement de la mise à jour du statut
if (isset($_POST['update_statut'])) {
    $unControleur->updateStatutCommande($_POST['id_commande'], $_POST['statut']);
}

// 🔹 Gère l'ouverture/fermeture des détails (toggle)
if (isset($_POST['voir_details'])) {
    $id_commande_click = $_POST['voir_details'];

    if (isset($_SESSION['commande_detail']) && $_SESSION['commande_detail'] == $id_commande_click) {
        unset($_SESSION['commande_detail']); // Deuxième clic → on referme
    } else {
        $_SESSION['commande_detail'] = $id_commande_click; // Premier clic → on affiche
    }
}

$idCommandeSelectionnee = $_SESSION['commande_detail'] ?? null;

if (isset($_POST['update_statut'])) {
    $id_commande = $_POST['id_commande'];
    $nouveau_statut = $_POST['statut'];

    if ($unControleur->updateStatutCommande($id_commande, $nouveau_statut)) {
        $_SESSION['flash_message'] = "Statut de la commande #$id_commande mis à jour en \"$nouveau_statut\" ✅";
    } else {
        $_SESSION['flash_message'] = "Erreur lors de la mise à jour du statut ❌";
    }
}

// 🔹 Récupération des commandes
$commandes = $unControleur->getAllCommandes();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des commandes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom right, #123524, #3E7B27);
      background-size: cover;
      min-height: 100vh;
      color: #fff;
      padding: 30px;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      background-color: rgba(18, 53, 36, 0.9);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
    }
    h2 {
  text-align: center;
  font-family: 'Montserrat', sans-serif;
  font-size: 28px;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #fff;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
  margin-bottom: 30px;
}
    .btn-primary {
      background-color: #85A947;
      border: none;
    }

    .btn-primary:hover {
      background-color: #a1c45d;
      color: #123524;
    }
    .badge-statut {
  padding: 6px 10px;
  border-radius: 8px;
  font-size: 0.8rem;
  text-transform: capitalize;
  display: inline-block;
}

.statut-enattente  { background-color: #ffc107; color: #000; }
.statut-payee      { background-color: #198754; color: #fff; }
.statut-expediee   { background-color: #0dcaf0; color: #000; }
.statut-livree     { background-color: #20c997; color: #000; }
.statut-annulee    { background-color: #dc3545; color: #fff; }


    .table thead th {
      background-color: #1c3b2d;
      color: #fff;
    }

    .table tbody tr {
      background-color: #2e5a41;
      color: #fff;
    }

    .table tbody tr:hover {
      background-color: #3e7b54;
    }

    .card-body {
      background-color: #1f3c2d;
      color: #fff;
    }

    .form-select,
    .btn-outline-success,
    .btn-outline-info {
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

  <div class="container">
  <?php if (isset($_SESSION['flash_message'])): ?>
  <div class="alert alert-success text-center">
    <?= htmlspecialchars($_SESSION['flash_message']) ?>
    <?php unset($_SESSION['flash_message']); ?>
  </div>
<?php endif; ?>
<h2 class="text-center mb-4">Liste des commandes</h2>

<div class="text-end mb-4">
  <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
</div>

    <table class="table table-bordered table-hover">
      <thead>
      <?php
function slugifyStatut($statut) {
    $statut = strtolower($statut);
    $statut = str_replace(['é', 'è', 'ê'], 'e', $statut);
    $statut = str_replace(['à', 'â'], 'a', $statut);
    $statut = str_replace(['î', 'ï'], 'i', $statut);
    $statut = str_replace(['ô'], 'o', $statut);
    $statut = str_replace(' ', '', $statut);
    return $statut;
}
?>
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
            <td>
            <span class="badge-statut statut-<?= slugifyStatut($commande['statut']) ?>">
    <?= htmlspecialchars($commande['statut']) ?>
  </span>
</td>
            <td><?= $commande['date_commande'] ?></td>
            <td class="d-flex gap-2">
              <!-- Modification statut -->
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

              <!-- Voir détails -->
              <form method="POST">
  <button type="submit" name="voir_details" value="<?= $commande['id_commande'] ?>" class="btn btn-sm btn-outline-info">
    <?= ($idCommandeSelectionnee == $commande['id_commande']) ? "Masquer détails" : "Voir détails" ?>
  </button>
</form>
            </td>
          </tr>

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

</body>
</html>