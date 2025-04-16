<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // 🔹 Vérifications
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse e-mail n'est pas valide.";
    } elseif ($password !== $confirm_password) {
        $message = "Les mots de passe ne correspondent pas.";
    } elseif ($unControleur->emailExists($email)) {
        $message = "Cet email est déjà utilisé.";
    } else {
        // 🔹 Création de l'utilisateur via le contrôleur
        if ($unControleur->createUser($nom, $prenom, $email, $password)) {
            $message = "Inscription réussie ! <a href='index.php?page=connexion'>Connectez-vous ici</a>.";
        } else {
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulaire d'inscription</title>
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
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      padding: 20px;
    }
    .main-title {
    font-family: 'Montserrat', sans-serif;
    position: absolute;
    top: 60px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 2em;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #fff;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
    animation: fadeInDown 1s ease forwards;
    z-index: 10;
  }

    .logo {
      position: fixed;
      top: 20px;
      left: 20px;
      width: 100px;
      height: auto;
      z-index: 1000;
    }

    .form-container {
      background-color: rgba(18, 53, 36, 0.85);
      padding: 20px;
      border-radius: 10px;
      width: 100%;
      max-width: 800px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
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

    .input-container {
      position: relative;
    }

    .input-container i {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #fff;
      font-size: 1.1em;
    }

    .input-container input {
      width: 100%;
      padding: 8px 8px 8px 32px;
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

    /* Responsive */
    @media (max-width: 600px) {
      .form-row {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
<header>
<h1 class="main-title">Formulaire d'Inscription</h1>
  <img src="static/logo-artiti.png" alt="Logo" class="logo" />
  </header>

  <div class="form-container">
    <form class="registration-form" method="post" action="">
      <?php if (!empty($message)) : ?>
        <p style="color: #ff6b6b; font-weight: bold; text-align: center; margin-bottom: 15px;">
          <?= $message ?>
        </p>
      <?php endif; ?>

      <div class="form-row">
  <div class="column">
    <!-- Prénom -->
    <div class="form-group icon-input">
      <label for="prenom">Prénom</label>
      <div class="input-container">
        <i class="fas fa-user"></i>
        <input type="text" id="prenom" name="prenom" required>
      </div>
    </div>

    <!-- Email -->
    <div class="form-group icon-input">
      <label for="email">Email</label>
      <div class="input-container">
        <i class="fas fa-envelope"></i>
        <input type="email" id="email" name="email" required>
      </div>
    </div>

    <!-- Code Postal -->
    <div class="form-group icon-input">
      <label for="code-postal">Code Postal</label>
      <div class="input-container">
        <i class="fas fa-map-marker-alt"></i>
        <input type="text" id="code-postal" name="code_postal" required>
      </div>
    </div>

    <!-- Mot de passe -->
    <div class="form-group icon-input">
      <label for="password">Mot de passe</label>
      <div class="input-container">
        <i class="fas fa-lock"></i>
        <input type="password" id="password" name="password" required>
      </div>
    </div>
  </div>

  <div class="column">
    <!-- Nom -->
    <div class="form-group icon-input">
      <label for="nom">Nom</label>
      <div class="input-container">
        <i class="fas fa-user"></i>
        <input type="text" id="nom" name="nom" required>
      </div>
    </div>

    <!-- Adresse -->
    <div class="form-group icon-input">
      <label for="adresse">Adresse</label>
      <div class="input-container">
        <i class="fas fa-home"></i>
        <input type="text" id="adresse" name="adresse" required>
      </div>
    </div>

    <!-- Ville -->
    <div class="form-group icon-input">
      <label for="ville">Ville</label>
      <div class="input-container">
        <i class="fas fa-city"></i>
        <input type="text" id="ville" name="ville" required>
      </div>
    </div>

    <!-- Confirmation du mot de passe -->
    <div class="form-group icon-input">
      <label for="confirm-password">Confirmer le mot de passe</label>
      <div class="input-container">
        <i class="fas fa-lock"></i>
        <input type="password" id="confirm_password" name="confirm_password" required>
      </div>
    </div>
  </div>
</div>


      <div class="actions">
        <button type="submit" name="inscription">S'inscrire</button>
        <div class="links">
          <a href="index.php?page=connexion">Déjà inscrit ? Connexion</a>
        </div>
      </div>
    </form>
  </div>

</body>
</html>