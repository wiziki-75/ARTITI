<style>
    /* Réinitialisation basique */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  /* Le body utilise une image de fond couvrant toute la page */
  /* Adaptez le chemin de l'image selon votre arborescence */
  body {
    font-family: Arial, sans-serif;
    background: url("../images/image6.png") no-repeat center center;
    background-size: cover;
    min-height: 100vh;
    position: relative;
    color: #fff; /* Texte blanc par défaut */
  }
  
  /* ----- HEADER ----- */
  header {
    position: relative;
    width: 100%;
    height: 200px; /* Ajustez selon votre maquette */
  }
  
  /* Logo en haut à gauche */
  .logo {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 100px; /* Ajustez la taille */
    height: auto;
    z-index: 10;
  }
  
  /* Titre principal stylisé */
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
  
  /* ----- CONTAINER DU FORMULAIRE ----- */
  .form-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(18, 53, 36, 0.8); /* Bloc vert semi-transparent */
    padding: 30px;
    border-radius: 10px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
  }
  
  /* ----- FORMULAIRE ----- */
  .login-form .form-group {
    margin-bottom: 20px;
  }
  
  .login-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #fff;
  }
  
  /* Conteneur pour icône + input */
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
  
  /* Input avec padding pour laisser la place à l'icône */
  .icon-input .input-container input {
    width: 100%;
    padding: 10px 10px 10px 35px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    color: #123524; /* Texte foncé dans l'input */
  }
  
  /* ----- ACTIONS (bouton et liens) ----- */
  .actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .actions button {
    background-color: #fff;
    color: #3E7B27;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
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
</style>

  <!-- CONTAINER DU FORMULAIRE -->
  <div class="form-container">
    <form class="login-form" method="post" action="">
      
      <!-- Champ Identifiant avec icône -->
      <div class="form-group icon-input">
        <label for="identifiant">Identifiant</label>
        <div class="input-container">
          <i class="fas fa-user"></i>
          <input type="text" id="identifiant" name="identifiant" required>
        </div>
      </div>
      
      <!-- Champ Mot de passe avec icône -->
      <div class="form-group icon-input">
        <label for="motDePasse">Mot de passe</label>
        <div class="input-container">
          <i class="fas fa-lock"></i>
          <input type="password" id="motDePasse" name="motDePasse" required>
        </div>
      </div>
      
      <!-- Bouton et liens -->
      <div class="actions">
        <button type="submit" name="login">Connexion</button>
        <div class="links">
          <a href="#">Mot de passe oublié ?</a>
          <a href="#">Inscription</a>
        </div>
      </div>
    </form>
  </div>

