<?php
class Adresse extends BDD {

    /**
     * Ajouter une adresse
     */
    public function addAdresse($id_user, $nom, $code_postal, $ville, $telephone) {
        $sql = "INSERT INTO Adresse (id_user, nom, code_postal, ville, telephone) 
                VALUES (:id_user, :nom, :code_postal, :ville, :telephone)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':nom' => $nom,
            ':code_postal' => $code_postal,
            ':ville' => $ville,
            ':telephone' => $telephone
        ]);
    }

    /**
     * Récupérer une adresse par son ID
     */
    public function getAdresseById($id_adresse) {
        $sql = "SELECT * FROM Adresse WHERE id_adresse = :id_adresse";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_adresse' => $id_adresse]);
        return $stmt->fetch();
    }

    /**
     * Récupérer toutes les adresses d'un utilisateur
     */
    public function getAdressesByUser($id_user) {
        $sql = "SELECT * FROM Adresse WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        return $stmt->fetchAll();
    }

    /**
     * Mettre à jour une adresse
     */
    public function updateAdresse($id_adresse, $nom, $code_postal, $ville, $telephone) {
        $sql = "UPDATE Adresse SET 
                    nom = :nom, 
                    code_postal = :code_postal, 
                    ville = :ville, 
                    telephone = :telephone
                WHERE id_adresse = :id_adresse";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_adresse' => $id_adresse,
            ':nom' => $nom,
            ':code_postal' => $code_postal,
            ':ville' => $ville,
            ':telephone' => $telephone
        ]);
    }

    /**
     * Supprimer une adresse par son ID
     */
    public function deleteAdresse($id_adresse) {
        $sql = "DELETE FROM Adresse WHERE id_adresse = :id_adresse";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_adresse' => $id_adresse]);
    }
}
?>
