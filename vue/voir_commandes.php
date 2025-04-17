<?php
if(!isset($_SESSION['email'])){
    header("Location: index.php?page=connexion");
}

if (isset($_POST['delete_detail'])) {
    $idDetail = $_POST['id_detail'];
    $unControleur->deleteDetailCommande($idDetail);

    $idCommande = $_POST['id_commande'];
    $unControleur->recalculerTotalCommande($idCommande);
}

$id_user = $_SESSION['user_id'];
$commandes = $unControleur->getCommandesByUser($id_user);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Commandes</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
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
      max-width: 900px;
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
      margin-bottom: 30px;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
    }

    .card {
      background-color: #2e5a41;
      color: #fff;
      border: none;
    }

    .card-header {
      background-color: #1c3b2d;
      font-weight: bold;
    }

    .list-group-item {
      background-color: #3e7b54;
      color: #fff;
      border: 1px solid #2e5a41;
    }

    .btn-danger {
      background-color: #dc3545;
      border: none;
    }

    .btn-danger:hover {
      background-color: #bb2d3b;
    }

    .btn-secondary {
      background-color: #85A947;
      border: none;
      margin-top: 20px;
    }

    .btn-secondary:hover {
      background-color: #a1c45d;
      color: #123524;
    }

    .text-muted {
      color: #ccc !important;
    }

    strong {
      color: #ffd;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Mes Commandes</h2>

    <?php if (empty($commandes)) : ?>
      <p>Aucune commande trouvée.</p>
    <?php else : ?>
      <?php foreach ($commandes as $commande) : ?>
        <div class="card mb-4">
          <div class="card-header">
            Commande #<?= $commande['id_commande'] ?> – <?= htmlspecialchars($commande['statut']) ?> – <?= $commande['date_commande'] ?>
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

    <div class="text-center">
      <a href="index.php?page=home" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
  </div>

</body>
</html>