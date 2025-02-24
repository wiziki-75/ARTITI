<?php
class BDD {
    public $pdo; // Objet PDO

    public function __construct(){
        $url = "mysql:host=localhost;dbname=artiti";
        $user = "root";
        $mdp = "";

        try {
            // Instanciation de la classe PDO
            $this->pdo = new PDO($url, $user, $mdp);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définir le mode d'erreur
        } catch (PDOException $exp) {
            die("Erreur connexion BDD : " . $exp->getMessage());
        }
    }
}

?>