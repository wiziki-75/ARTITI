<?php
class Commande extends BDD {

    /**
     * Créer une commande et insérer ses détails
     */
    public function createCommande($id_user, $total, $panier) {
        try {
            $this->pdo->beginTransaction();

            // 🔹 Insérer la commande
            $sql = "INSERT INTO Commandes (id_user, statut, total, date_commande) 
                    VALUES (:id_user, 'en attente', :total, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_user' => $id_user,
                ':total' => $total
            ]);

            // 🔹 Récupérer l'ID de la commande créée
            $id_commande = $this->pdo->lastInsertId();

            // 🔹 Insérer les détails de la commande
            $sqlDetails = "INSERT INTO Details_commande (id_commande, id_produit, quantite, prix_unitaire) 
                           VALUES (:id_commande, :id_produit, :quantite, :prix_unitaire)";
            $stmtDetails = $this->pdo->prepare($sqlDetails);

            foreach ($panier as $item) {
                $stmtDetails->execute([
                    ':id_commande' => $id_commande,
                    ':id_produit' => $item['id_produit'],
                    ':quantite' => $item['quantite'],
                    ':prix_unitaire' => $item['prix_unitaire']
                ]);
            }

            // 🔹 Vider le panier après validation
            $sqlClearPanier = "DELETE FROM Panier WHERE id_user = :id_user";
            $stmtClear = $this->pdo->prepare($sqlClearPanier);
            $stmtClear->execute([':id_user' => $id_user]);

            $this->pdo->commit();
            return $id_commande;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * Récupérer toutes les commandes d'un utilisateur
     */
    public function getCommandesByUser($id_user) {
        $sql = "SELECT * FROM Commandes WHERE id_user = :id_user ORDER BY date_commande DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les détails d'une commande
     */
    public function getDetailsCommande($id_commande) {
        $sql = "SELECT Details_commande.*, Produit.nom 
                FROM Details_commande 
                JOIN Produit ON Details_commande.id_produit = Produit.id_produit
                WHERE id_commande = :id_commande";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_commande' => $id_commande]);
        return $stmt->fetchAll();
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatutCommande($id_commande, $statut) {
        $sql = "UPDATE Commandes SET statut = :statut WHERE id_commande = :id_commande";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_commande' => $id_commande,
            ':statut' => $statut
        ]);
    }

    /**
     * Supprimer une commande et ses détails
     */
    public function deleteCommande($id_commande) {
        try {
            $this->pdo->beginTransaction();

            // 🔹 Supprimer les détails de la commande
            $sqlDetails = "DELETE FROM Details_commande WHERE id_commande = :id_commande";
            $stmtDetails = $this->pdo->prepare($sqlDetails);
            $stmtDetails->execute([':id_commande' => $id_commande]);

            // 🔹 Supprimer la commande
            $sqlCommande = "DELETE FROM Commandes WHERE id_commande = :id_commande";
            $stmtCommande = $this->pdo->prepare($sqlCommande);
            $stmtCommande->execute([':id_commande' => $id_commande]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
?>
