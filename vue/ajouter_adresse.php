<?php
// 🔹 Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: index.php?page=connexion");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $code_postal = trim($_POST['code_postal']);
    $ville = trim($_POST['ville']);
    $telephone = trim($_POST['telephone']);

    // 🔹 Vérifications de base
    if (empty($nom) || empty($code_postal) || empty($ville) || empty($telephone)) {
        $message = "Tous les champs doivent être remplis.";
    } elseif (!preg_match("/^\d{5}$/", $code_postal)) {
        $message = "Le code postal doit être un nombre à 5 chiffres.";
    } elseif (!preg_match("/^\d{10}$/", $telephone)) {
        $message = "Le numéro de téléphone doit contenir 10 chiffres.";
    } else {
        // 🔹 Ajouter l'adresse dans la base
        $id_user = $_SESSION['user_id']; // ID de l'utilisateur connecté
        $ajoutReussi = $unControleur->addAdresse($id_user, $nom, $code_postal, $ville, $telephone);

        if ($ajoutReussi) {
            $message = "Adresse ajoutée avec succès !";
        } else {
            $message = "Erreur lors de l'ajout de l'adresse.";
        }
    }
}
?>

<div class="container mt-5">
    <h2>Ajouter une Adresse</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nom de l'Adresse</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Code Postal</label>
            <input type="text" name="code_postal" class="form-control" required pattern="\d{5}" title="Entrez un code postal à 5 chiffres">
        </div>
        <div class="mb-3">
            <label>Ville</label>
            <input type="text" name="ville" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required pattern="\d{10}" title="Entrez un numéro de téléphone à 10 chiffres">
        </div>
        <button type="submit" class="btn btn-success">Ajouter l'Adresse</button>
    </form>
    <p class="mt-3"><a href="index.php?page=home">Retour à l'accueil</a></p>
</div>