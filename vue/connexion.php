<?php
// 🔹 Si l'utilisateur est déjà connecté, on le redirige vers la home
if (isset($_SESSION['email'])) {
    header("Location: index.php?page=home");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // 🔹 Vérifier si l'utilisateur existe
    $user = $unControleur->getUserByEmail($email);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // 🔹 Enregistrement des informations en session
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id'] = $user['id_user'];

        // 🔹 Mettre à jour la dernière connexion
        $unControleur->updateLastLogin($user['id_user']);

        // 🔹 Redirection vers la page d'accueil
        header("Location: index.php?page=home");
        exit();
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <!-- 🔹 Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: Arial, sans-serif;
    background: url('static/Agriculture.png') no-repeat center center;
    background-size: cover;
    min-height: 100vh;
    position: relative;
    color: #fff;
  }

  header {
    position: relative;
    width: 100%;
    height: 200px;
  }

  .logo {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 100px;
    height: auto;
    z-index: 10;
  }

  .main-title {
    font-family: 'Montserrat', sans-serif;
    position: absolute;
    top: 60px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 3em;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #fff;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
    animation: fadeInDown 1s ease forwards;
    z-index: 10;
  }

  @keyframes fadeInDown {
    0% {
      opacity: 0;
      transform: translate(-50%, -30px);
    }
    100% {
      opacity: 1;
      transform: translate(-50%, 0);
    }
  }

  .form-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(18, 53, 36, 0.8);
    padding: 30px;
    border-radius: 20px; /* Arrondi amélioré */
    max-width: 400px;
    width: 90%;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
  }

  .login-form .form-group {
    margin-bottom: 20px;
  }

  .login-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #fff;
  }

  .icon-input .input-container {
    position: relative;
  }

  .icon-input .input-container i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    font-size: 1.1em;
  }

  .icon-input .input-container input {
    width: 100%;
    padding: 10px 10px 10px 35px;
    border: none;
    border-radius: 20px; /* Arrondi amélioré */
    font-size: 16px;
    color: #123524;
  }

  .actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
  }

  .actions button {
    flex: 1;
    max-width: 150px;
    text-align: center;
    background-color: #fff;
    color: #3E7B27;
    border: none;
    padding: 10px 20px;
    border-radius: 20px; /* Arrondi amélioré */
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
  }

  .actions button:hover {
    background-color: #85A947;
    color: #fff;
  }

  .actions .links a {
    margin-left: 10px;
    text-decoration: none;
    color: #fff;
  }

  .actions .links a:hover {
    text-decoration: underline;
  }

  .error-message {
    color: #ff6b6b;
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center;
  }
</style>

</head>
<body>

  <!-- HEADER (facultatif ici) -->
  <header>
    <img src="static/logo2.png" alt="Logo" class="logo">
    <h1 class="main-title">Connexion</h1>
  </header>

  <!-- FORMULAIRE -->
  <div class="form-container">
    <form class="login-form" method="post" action="">
      
      <!-- Message d'erreur -->
      <?php if (isset($message)) : ?>
        <p class="error-message"><?= $message ?></p>
      <?php endif; ?>

      <!-- Email -->
      <div class="form-group icon-input">
        <label for="email">Email</label>
        <div class="input-container">
          <i class="fas fa-user"></i>
          <input type="text" id="email" name="email" required>
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

      <!-- Bouton + liens -->
      <div class="actions">
        <!-- Bouton + liens -->
<div class="actions">
  <button type="submit" name="login">Connexion</button>
  <button type="button" onclick="window.location.href='index.php?page=inscription'">Inscription</button>
</div>
        <div class="links">
        </div>
      </div>
    </form>
  </div>

</body>
</html>