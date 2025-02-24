<?php
class Produit extends BDD {

    /**
     * Ajouter un produit
     */
    public function addProduit($nom, $prix, $vendeur, $type, $quantite) {
        $sql = "INSERT INTO Produit (nom, prix, vendeur, date, type, quantite) 
                VALUES (:nom, :prix, :vendeur, NOW(), :type, :quantite)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prix' => $prix,
            ':vendeur' => $vendeur,
            ':type' => $type,
            ':quantite' => $quantite
        ]);
    }

    /**
     * Récupérer un produit par son ID
     */
    public function getProduitById($id_produit) {
        $sql = "SELECT * FROM Produit WHERE id_produit = :id_produit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_produit' => $id_produit]);
        return $stmt->fetch();
    }

    /**
     * Récupérer tous les produits
     */
    public function getAllProduits() {
        $sql = "SELECT * FROM Produit";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer tous les produits d'un vendeur spécifique
     */
    public function getProduitsByVendeur($id_vendeur) {
        $sql = "SELECT * FROM Produit WHERE vendeur = :id_vendeur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_vendeur' => $id_vendeur]);
        return $stmt->fetchAll();
    }

    /**
     * Mettre à jour un produit
     */
    public function updateProduit($id_produit, $nom, $prix, $type, $quantite) {
        $sql = "UPDATE Produit SET 
                    nom = :nom, 
                    prix = :prix, 
                    type = :type, 
                    quantite = :quantite 
                WHERE id_produit = :id_produit";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_produit' => $id_produit,
            ':nom' => $nom,
            ':prix' => $prix,
            ':type' => $type,
            ':quantite' => $quantite
        ]);
    }

    /**
     * Supprimer un produit par son ID
     */
    public function deleteProduit($id_produit) {
        $sql = "DELETE FROM Produit WHERE id_produit = :id_produit";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_produit' => $id_produit]);
    }
}
?>
