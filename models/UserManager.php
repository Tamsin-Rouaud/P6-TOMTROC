<?php

class UserManager extends AbstractEntityManager
{
    // Méthodes pour gérer les utilisateurs

    public function emailExists($email)
    {
        $pdo = DBManager::getInstance()->getPDO(); // Récupère l'objet PDO
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function usernameExists($username)
    {
        $pdo = DBManager::getInstance()->getPDO(); // Récupère l'objet PDO
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    public function createUser($username, $email, $password)
    {
        $pdo = DBManager::getInstance()->getPDO(); // Récupère l'objet PDO
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, user_creation_date) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $email, $password]);
    }

    public function findUserByEmail($email)
    {
        $pdo = DBManager::getInstance()->getPDO(); // Récupère l'objet PDO
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validateUserData($email, $username = null, $password = null)
    {
        $errors = [];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Veuillez fournir une adresse email valide.";
        }

        if ($username && empty($username)) {
            $errors[] = "Veuillez fournir un pseudo.";
        }

        if ($password && (empty($password) || strlen($password) < 6)) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
        }

        // Utilisation des méthodes pour vérifier si l'email ou le pseudo existe déjà
        if ($this->emailExists($email)) {
            $errors[] = "Cet email est déjà utilisé.";
        }

        if ($username && $this->usernameExists($username)) {
            $errors[] = "Ce pseudo est déjà utilisé.";
        }

        return $errors;
    }

    public function validateUserDataLogin($email, $password)
{
    $errors = [];

    // Validation de l'email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Veuillez fournir une adresse email valide.";
    }

    // Validation du mot de passe
    if (empty($password)) {
        $errors[] = "Veuillez fournir un mot de passe.";
    }

   
    return $errors;
}

public function findUserById(int $userId)
{
    $sql = "SELECT id_users, username, email FROM users WHERE id_users = :id";
    $params = [':id' => $userId];
    return $this->db->query($sql, $params)->fetch();
}

/**
     * Met à jour le chemin de l'image d'un utilisateur.
     *
     * @param int $userId
     * @param string $imagePath
     * @return void
     */
    public function updateUserImagePath(int $userId, string $imagePath): void
    {
        $sql = "UPDATE users SET image_path = :imagePath WHERE id = :userId";
        $params = [
            ':imagePath' => $imagePath,
            ':userId' => $userId,
        ];

        $this->db->query($sql, $params);
    }

    /**
     * Récupère l'image actuelle d'un utilisateur.
     *
     * @param int $userId
     * @return string
     */
    public function getUserImagePath(int $userId): string
    {
        $sql = "SELECT image_path FROM users WHERE id = :userId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() ?? 'uploads/users/defaultAvatar.png';
    }

}
