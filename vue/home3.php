<?php
$produits = $unControleur->getAllProduits();
$total_articles = 0;

// Traitement de l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_produit']) && !empty($_POST['prix_unitaire'])) {
    if (!empty($_SESSION['user_id'])) {
        $id_produit = (int) $_POST['id_produit'];
        $prix_unitaire = (float) $_POST['prix_unitaire'];

        $ajoutReussi = $unControleur->addToPanier($_SESSION['user_id'], $id_produit, 1, $prix_unitaire);
        $message = $ajoutReussi ? "Produit ajouté au panier !" : "Erreur lors de l'ajout au panier.";
    } else {
        header("Location: index.php?page=connexion");
        exit(); // Toujours sortir après une redirection
    }
}

// Fonctions utilitaires
function get_image(string $type): string
{
    $images = [
        'viande'   => 'feature-1.jpg',
        'banane'   => 'feature-2.jpg',
        'goyave'   => 'feature-3.jpg',
        'pasteque' => 'feature-4.jpg',
        'raisin'   => 'feature-5.jpg',
        'mangue'   => 'feature-7.jpg',
        'pomme'    => 'feature-8.jpg'
    ];

    return $images[$type] ?? 'default.jpg';
}

function get_cat(string $type): string
{
    $fruits = ['banane', 'goyave', 'pasteque', 'raisin', 'mangue', 'pomme'];

    return in_array($type, $fruits) ? 'fruit' : 'fresh-meat';
}
?>


<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="static/img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__auth">
            <a href="#"><i class="fa fa-user"></i> </a>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="index.php">Accueil</a></li>
            <li><a href="./shop-grid.html">Commande</a></li>
            <li><a href="./shop-grid.html">Ajouter un produit</a></li>
            <!-- <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shoping-cart.html">Panier</a></li>
                    <li><a href="./checkout.html">Paiement</a></li>
                </ul>
            </li> -->
            <li><a href="./contact.html">Panier</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <div class="header__top__right__auth">
                            <?php
                            if (isset($_SESSION['email'])) {
                                echo '<a href="index.php?page=deconnexion"><i class="fa fa-user"></i> Se déconnecter</a>';
                            } else {
                                echo '<a href="index.php?page=connexion"><i class="fa fa-user"></i> Connexion</a>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="index.php"><img src="static/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="index.php">Accueil</a></li>
                        <li><a href="#">Espace client</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="index.php?page=panier">Panier</a></li>
                                <li><a href="index.php?page=voir_commandes">Commande</a></li>
                            </ul>
                        </li>

                        <?php if (isset($_SESSION['role'])): ?>
                            <?php if ($_SESSION['role'] === 'vendeur'): ?>
                                <li><a href="#">Espace vendeur</a>
                                    <ul class="header__menu__dropdown">
                                        <li><a href="index.php?page=ajouter_produit">Ajouter un produit</a></li>
                                        <li><a href="index.php?page=commande_vendeur">Commandes</a></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li><a href="index.php?page=passer_vendeur">Passer vendeur</a></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- <li><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./shop-details.html">Détails de la boutique</a></li>
                                <li><a href="./shoping-cart.html">Panier</a></li>
                                <li><a href="./checkout.html">Paiement</a></li>
                            </ul>
                        </li> -->
                        <li><a href="#">Questions & Réponses</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="#">Commerçant</a></li>
                                <li><a href="#">Consommateur</a></li>
                            </ul>
                        </li>
                    </ul>

                </nav>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Tous les rayons</span>
                    </div>
                    <ul>
                        <li><a href="#">Viande</a></li>
                        <li><a href="#">Légumes</a></li>
                        <li><a href="#">Fruits & Noix</a></li>
                        <li><a href="#">Baies fraîches</a></li>
                        <li><a href="#">Beurre & Œufs</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                Toutes les catégories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="De quoi avez-vous besoin ?">
                            <button type="submit" class="site-btn">RECHERCHER</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+33 1 67 89 76 92</h5>
                            <span>assistance 24h/24 et 7j/7</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="static/img/hero/banner.jpg">
                    <div class="hero__text">
                        <span>PRODUITS FRAIS</span>
                        <h2> <br />100% Biologiques</h2>
                        <p>Retrait et livraison gratuits disponibles dès 30€ d'achat</p>
                        <a href="#produits" class="primary-btn">ACHETER MAINTENANT</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad" id="produits">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Produits</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">Tous</li>
                        <li data-filter=".fruit">Fruits</li>
                        <li data-filter=".fresh-meat">Viande fraîche</li>
                        <li data-filter=".vegetables">Légumes</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            <?php foreach ($produits as $produit) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges <?= get_cat($produit['type']) ?>">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="static/img/featured/<?= get_image($produit['type']) ?>">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li>
                                    <form method="post">
                                        <input type="hidden" name="id_produit" value="<?= $produit['id_produit'] ?>">
                                        <input type="hidden" name="prix_unitaire" value="<?= $produit['prix'] ?>">
                                        <button type="submit" class="btn btn-link" style="padding: 0; border: none; background: none;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#"><?= htmlspecialchars($produit['nom']) ?></a></h6>
                            <h5><?= $produit['prix'] ?> / KG</h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
</section>

<!-- Featured Section End -->

<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="index.php"><img src="static/img/logo.png" alt="Artiti Logo"></a>
                    </div>
                    <ul>
                        <li>Adresse : 42 Rue de la Création, 75011 Paris</li>
                        <li>Téléphone : +33 1 23 45 67 89</li>
                        <li>Email : contact@artiti.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Liens utiles</h6>
                    <ul>
                        <li><a href="#">À propos d'Artiti</a></li>
                        <li><a href="#">Notre boutique</a></li>
                        <li><a href="#">Paiement sécurisé</a></li>
                        <li><a href="#">Livraison</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Plan du site</a></li>
                    </ul>
                    <ul>
                        <li><a href="#">Notre mission</a></li>
                        <li><a href="#">Nos services</a></li>
                        <li><a href="#">Projets</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Innovation</a></li>
                        <li><a href="#">Avis clients</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Abonne-toi à notre newsletter</h6>
                    <p>Sois au courant des nouveautés et des offres exclusives d’Artiti.</p>
                    <form action="#">
                        <input type="text" placeholder="Ton e-mail ici">
                        <button type="submit" class="site-btn">S’abonner</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p>
                            &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Tous droits réservés |
                            Design signé avec <i class="fa fa-heart" aria-hidden="true"></i> par l’équipe Artiti
                        </p>
                    </div>
                    <div class="footer__copyright__payment">
                        <img src="static/img/payment-item.png" alt="Méthodes de paiement">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="static/js/jquery-3.3.1.min.js"></script>
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/jquery.nice-select.min.js"></script>
<script src="static/js/jquery-ui.min.js"></script>
<script src="static/js/jquery.slicknav.js"></script>
<script src="static/js/mixitup.min.js"></script>
<script src="static/js/owl.carousel.min.js"></script>
<script src="static/js/main.js"></script>