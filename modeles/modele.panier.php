<?php
class Panier extends BDD {

    /**
     * Ajouter un produit au panier
     */
    public function addToPanier($id_user, $id_produit, $quantite, $prix_unitaire) {
        $sql = "INSERT INTO Panier (id_user, id_produit, quantite, prix_unitaire) 
                VALUES (:id_user, :id_produit, :quantite, :prix_unitaire)
                ON DUPLICATE KEY UPDATE quantite = quantite + :quantite";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':id_produit' => $id_produit,
            ':quantite' => $quantite,
            ':prix_unitaire' => $prix_unitaire
        ]);
    }

    /**
     * Récupérer le panier d'un utilisateur
     */
    public function getPanierByUser($id_user) {
        $sql = "SELECT Panier.*, Produit.nom 
                FROM Panier 
                JOIN Produit ON Panier.id_produit = Produit.id_produit
                WHERE Panier.id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        return $stmt->fetchAll();
    }

    /**
     * Modifier la quantité d'un produit dans le panier
     */
    public function updatePanier($id_user, $id_produit, $quantite) {
        $sql = "UPDATE Panier SET quantite = :quantite 
                WHERE id_user = :id_user AND id_produit = :id_produit";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':quantite' => $quantite,
            ':id_user' => $id_user,
            ':id_produit' => $id_produit
        ]);
    }

    /**
     * Supprimer un produit du panier
     */
    public function deleteFromPanier($id_user, $id_produit) {
        $sql = "DELETE FROM Panier WHERE id_user = :id_user AND id_produit = :id_produit";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':id_produit' => $id_produit
        ]);
    }

    /**
     * Vider complètement le panier d'un utilisateur
     */
    public function clearPanier($id_user) {
        $sql = "DELETE FROM Panier WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_user' => $id_user]);
    }
}
?>
