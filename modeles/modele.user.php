<?php
class User extends BDD {

    /**
     * Créer un utilisateur
     */
    public function createUser($nom, $prenom, $email, $mot_de_passe, $role = 'client') {
        $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
        $sql = "INSERT INTO User (nom, prenom, email, date_inscription, role, mot_de_passe) 
                VALUES (:nom, :prenom, :email, NOW(), :role, :mot_de_passe)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':role' => $role,
            ':mot_de_passe' => $hash
        ]);
    }

    /**
     * Récupérer un utilisateur par ID
     */
    public function getUserById($id_user) {
        $sql = "SELECT * FROM User WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        return $stmt->fetch();
    }

    /**
     * Récupérer un utilisateur par email (utile pour la connexion)
     */
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM User WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM User WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Mettre à jour les informations d'un utilisateur
     */
    public function updateUser($id_user, $nom, $prenom, $email, $role) {
        $sql = "UPDATE User SET nom = :nom, prenom = :prenom, email = :email, role = :role 
                WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':role' => $role
        ]);
    }

    /**
     * Mettre à jour le mot de passe d'un utilisateur
     */
    public function updatePassword($id_user, $new_password) {
        $hash = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE User SET mot_de_passe = :mot_de_passe WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':mot_de_passe' => $hash
        ]);
    }

    /**
     * Mettre à jour la dernière connexion d'un utilisateur
     */
    public function updateLastLogin($id_user) {
        $sql = "UPDATE User SET derniere_connexion = NOW() WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_user' => $id_user]);
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUser($id_user) {
        $sql = "DELETE FROM User WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_user' => $id_user]);
    }

    /**
     * Récupérer tous les utilisateurs
     */
    public function getAllUsers() {
        $sql = "SELECT * FROM User";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function updateUserRole($id_user, $role) {
        $sql = "UPDATE User SET role = :role WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':role' => $role
        ]);
    }    
}
?>
