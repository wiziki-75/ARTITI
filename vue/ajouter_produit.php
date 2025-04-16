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
  <title>Ajouter un Produit</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom right, #123524, #3E7B27);
      background-size: cover;
      min-height: 100vh;
      color: #fff;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .logo {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 100px;
    height: auto;
    z-index: 10;
  }

    .form-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      max-width: 600px;
    }

    .form-title {
      text-align: center;
      margin-bottom: 25px;
      font-family: 'Montserrat', sans-serif;
      font-size: 28px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
    }

    .form-container {
      background-color: rgba(18, 53, 36, 0.85);
      padding: 30px;
      border-radius: 10px;
      width: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 8px;
      font-size: 15px;
      border: none;
      border-radius: 4px;
    }

    .form-actions {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 20px;
    }

    .form-actions button {
      background-color: #fff;
      color: #3E7B27;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      transition: 0.3s;
    }

    .form-actions button:hover {
      background-color: #85A947;
      color: #fff;
    }

    .form-actions a {
      margin-top: 10px;
      text-decoration: none;
      color: #fff;
      font-size: 14px;
    }

    .form-actions a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="form-wrapper">
    <h2 class="form-title">Ajouter un Produit</h2>
    <img src="static/logo-artiti.png" alt="Logo" class="logo" />

    <form method="post" class="form-container">
      <div class="form-group">
        <label>Nom du Produit</label>
        <input type="text" name="nom" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Prix (€)</label>
        <input type="text" name="prix" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Type de Produit</label>
        <select name="type" class="form-control" required>
          <option value="">Sélectionnez un type</option>
          <option value="viande">Viande</option>
          <option value="banane">Banane</option>
          <option value="goyave">Goyave</option>
          <option value="pasteque">Pasteque</option>
          <option value="raisin">Raisin</option>
          <option value="mangue">Mangue</option>
          <option value="pomme">Pomme</option>
        </select>
      </div>

      <div class="form-group">
        <label>Quantité en Stock</label>
        <input type="number" name="quantite" class="form-control" required>
      </div>

      <div class="form-actions">
        <button type="submit">Ajouter le Produit</button>
        <a href="index.php?page=home">Retour à l'accueil</a>
      </div>
    </form>
  </div>

</body>
</html>
