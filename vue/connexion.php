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

<div class="container mt-5">
    <h2>Connexion</h2>
    <form method="post">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <p class="mt-3">Pas encore inscrit ? <a href="index.php?page=inscription">Créer un compte</a></p>
</div>