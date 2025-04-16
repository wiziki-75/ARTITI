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
        $id_user = $_SESSION['user_id'];
        $commerceCree = $unControleur->createCommerce($id_user, $description, $siret, $adresse, $code_postal, $ville, $telephone, $site_web, $email_contact);

        if ($commerceCree) {
            if ($unControleur->updateUserRole($id_user, 'vendeur')) {
                $_SESSION['role'] = 'vendeur';
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
  }

  .logo {
    position: fixed;
    top: 20px;
    left: 20px;
    width: 100px;
    height: auto;
    z-index: 1000;
  }

  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .form-container {
    background-color: rgba(18, 53, 36, 0.85);
    padding: 30px;
    border-radius: 10px;
    width: 100%;
    max-width: 800px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
  }

  .form-title {
    text-align: center;
    margin-bottom: 30px;
    font-family: 'Montserrat', sans-serif;
    font-size: 26px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #fff;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
  }

  .form-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
  }

  .column {
    flex: 1;
    min-width: 250px;
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

  .actions {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
  }

  .actions button {
    background-color: #fff;
    color: #3E7B27;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    font-size: 15px;
    margin-bottom: 10px;
    transition: 0.3s;
  }

  .actions button:hover {
    background-color: #85A947;
    color: #fff;
  }
  

  .links a {
    text-decoration: none;
    color: #fff;
    font-size: 14px;
  }

  .links a:hover {
    text-decoration: underline;
  }

  @media (max-width: 600px) {
    .form-row {
      flex-direction: column;
    }
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

<div class="container">
  <div class="form-wrapper">
    <h2 class="form-title">Devenir Vendeur</h2>
    <img src="static/logo-artiti.png" alt="Logo" class="logo" />
    <form method="post">
      <div class="form-container">
      <!-- Ligne 1 -->
      <div class="form-row">
        <div class="column">
          <div class="form-group">
            <label>Description de votre commerce</label>
            <input name="description" class="form-control" required>
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label>Numéro SIRET</label>
            <input type="text" name="siret" class="form-control" required>
          </div>
        </div>
      </div>

      <!-- Ligne 2 -->
      <div class="form-row">
        <div class="column">
          <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control" required>
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label>Code Postal</label>
            <input type="text" name="code_postal" class="form-control" required>
          </div>
        </div>
      </div>

      <!-- Ligne 3 -->
      <div class="form-row">
        <div class="column">
          <div class="form-group">
            <label>Ville</label>
            <input type="text" name="ville" class="form-control" required>
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required>
          </div>
        </div>
      </div>

      <!-- Ligne 4 -->
      <div class="form-row">
        <div class="column">
          <div class="form-group">
            <label>Site Web (optionnel)</label>
            <input type="text" name="site_web" class="form-control">
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label>Email de Contact</label>
            <input type="email" name="email_contact" class="form-control" required>
          </div>
        </div>
      </div>

      <!-- Boutons -->
      <div class="actions">
        <button type="submit">Valider</button>
        <div class="links">
          <a href="index.php?page=home">Retour à l'accueil</a>
        </div>
      </div>
    </div>
  </form>
</div>
