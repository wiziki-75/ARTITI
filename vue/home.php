<?php
// 🔹 Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: index.php?page=connexion");
    exit();
}

// 🔹 Récupération des informations utilisateur
$email = $_SESSION['email'] ?? 'Non défini';
$role = $_SESSION['role'] ?? 'Utilisateur';
$id_user = $_SESSION['user_id'] ?? 0;

// 🔹 Gestion de l'ajout au panier directement ici
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_produit'], $_POST['prix_unitaire'])) {
    if (!isset($_SESSION['user_id'])) {
        $message = "Erreur : Vous devez être connecté pour ajouter au panier.";
    } else {
        $id_produit = $_POST['id_produit'];
        $prix_unitaire = $_POST['prix_unitaire'];
        
        $ajoutReussi = $unControleur->addToPanier($id_user, $id_produit, 1, $prix_unitaire);
        if ($ajoutReussi) {
            $message = "Produit ajouté au panier !";
        } else {
            $message = "Erreur lors de l'ajout au panier.";
        }
    }
}


// 🔹 Récupérer tous les produits et le panier
$produits = $unControleur->getAllProduits();
$panier = $unControleur->getPanierByUser($id_user);
$total_articles = 0;
$total_prix = 0;

foreach ($panier as $item) {
    $total_articles += $item['quantite'];
    $total_prix += $item['quantite'] * $item['prix_unitaire'];
}
?>

<style>
    body {
        background-color: #E6D5AB;
        font-family: Arial, sans-serif;
    }

    /* Logo */
    .logo-container img {
        width: 100px;
        /* Ajustement de la taille */
        height: auto;
    }

    .logo-panier {
        width: 35px;
        /* Ajustement de la taille */
        height: auto;
    }

    /* Barre de navigation */
    .navbar {
        background-color: #E6D5AB;
        padding: 10px;
    }

    /* Boutons de catÃ©gorie */
    .category-btn {
        background-color: #4F7D3D;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: bold;
        margin: 5px;
    }

    /* Barre de recherche */
    .search-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px 0;
    }

    .search-bar input {
        border-radius: 25px;
        padding: 10px;
        border: none;
        width: 250px;
    }

    .search-bar button {
        background: none;
        border: none;
    }

    /* Cartes produits */
    .product-card {
        background: rgba(255, 255, 255, 0.7);
        width: 100%;
        border-radius: 30px;
        padding: 15px;
        text-align: center;
        margin: 10px;

    }

    .product-card img {

        width: 100%;
        height: auto;
        border-radius: 20px;
        max-height: 150px;
        object-fit: cover;
    }

    .product-card button {
        background-color: #4F7D3D;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
    }

    /* Pagination */
    .pagination-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
</style>

<div class="navbar d-flex justify-content-between align-items-center px-3">
    <div class="logo-container">
        <img src="./static/logo.png" alt="Logo Artiti">
    </div>
    <button class="btn position-relative">
        <img class="logo-panier" src="./static/panier.png" alt="Panier">
        <span class="position-absolute top-0 start-100 translate-middle badge bg-success">1</span>
    </button>
</div>

<div class="text-center my-3">
    <button class="category-btn">BOISSON</button>
    <button class="category-btn">FECULENT</button>
    <button class="category-btn">FRUIT</button>
    <button class="category-btn">LEGUME</button>
</div>

<div class="search-bar">
    <button>🔍</button>
    <input type="text" placeholder="Rechercher un produit">
</div>

<div class="row justify-content-center">
    <?php foreach ($produits as $produit) : ?>
        <div class="col-md-3">
            <div class="product-card">
                <!-- <img src="./img/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>"> -->
                <h5><?= htmlspecialchars($produit['nom']) ?></h5>
                <p><?= htmlspecialchars($produit['prix']) ?>€/KG</p>
                <button>Ajouter au panier</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="pagination-buttons px-3">
    <button class="btn btn-success">← Précédent</button>
    <span>Page 2/105</span>
    <button class="btn btn-success">Suivant →</button>
</div>