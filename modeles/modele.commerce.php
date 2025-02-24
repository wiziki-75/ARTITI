<?php
class Commerce extends BDD {

    /**
     * Créer un commerce
     */
    public function createCommerce($id_user, $description, $siret, $adresse, $code_postal, $ville, $telephone, $site_web, $email) {
        $sql = "INSERT INTO Commerce (id_user, description, siret, adresse, code_postal, ville, telephone, site_web, email, date_creation) 
                VALUES (:id_user, :description, :siret, :adresse, :code_postal, :ville, :telephone, :site_web, :email, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':description' => $description,
            ':siret' => $siret,
            ':adresse' => $adresse,
            ':code_postal' => $code_postal,
            ':ville' => $ville,
            ':telephone' => $telephone,
            ':site_web' => $site_web,
            ':email' => $email
        ]);
    }

    /**
     * Récupérer un commerce par son ID
     */
    public function getCommerceById($id_commerce) {
        $sql = "SELECT * FROM Commerce WHERE id_commerce = :id_commerce";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_commerce' => $id_commerce]);
        return $stmt->fetch();
    }

    /**
     * Récupérer un commerce par l'ID de l'utilisateur propriétaire
     */
    public function getCommerceByUserId($id_user) {
        $sql = "SELECT * FROM Commerce WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        return $stmt->fetch();
    }

    /**
     * Mettre à jour les informations d'un commerce
     */
    public function updateCommerce($id_commerce, $description, $siret, $adresse, $code_postal, $ville, $telephone, $site_web, $email) {
        $sql = "UPDATE Commerce SET 
                    description = :description, 
                    siret = :siret, 
                    adresse = :adresse, 
                    code_postal = :code_postal, 
                    ville = :ville, 
                    telephone = :telephone, 
                    site_web = :site_web, 
                    email = :email 
                WHERE id_commerce = :id_commerce";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_commerce' => $id_commerce,
            ':description' => $description,
            ':siret' => $siret,
            ':adresse' => $adresse,
            ':code_postal' => $code_postal,
            ':ville' => $ville,
            ':telephone' => $telephone,
            ':site_web' => $site_web,
            ':email' => $email
        ]);
    }

    /**
     * Supprimer un commerce par son ID
     */
    public function deleteCommerce($id_commerce) {
        $sql = "DELETE FROM Commerce WHERE id_commerce = :id_commerce";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_commerce' => $id_commerce]);
    }

    /**
     * Récupérer tous les commerces
     */
    public function getAllCommerces() {
        $sql = "SELECT * FROM Commerce";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>
