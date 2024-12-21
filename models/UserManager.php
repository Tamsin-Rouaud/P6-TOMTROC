<?php

class UserManager extends AbstractEntityManager
{
    /**
     * Vérifie si un email existe déjà dans la base de données.
     */
    public function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        return $result->fetchColumn() > 0;
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     */
    public function createUser(string $email, string $hashedPassword): bool
    {
        $sql = "INSERT INTO users (email, password, created_at) VALUES (:email, :password, NOW())";
        return $this->db->query($sql, [
            'email' => $email,
            'password' => $hashedPassword,
        ])->rowCount() > 0;
    }

    /**
     * Récupère un utilisateur par son email.
     */
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $result = $this->db->query($sql, ['email' => $email]);
        $data = $result->fetch();

        if ($data) {
            return new User($data); // Hydratation automatique via AbstractEntity
        }

        return null;
    }

    /**
     * Récupère un utilisateur par son ID.
     */
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $id]);
        $data = $result->fetch();

        if ($data) {
            return new User($data); // Hydratation automatique via AbstractEntity
        }

        return null;
    }
}
