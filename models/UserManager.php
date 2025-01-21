<?php
class UserManager extends AbstractEntityManager
{
    public function __construct() {
        // Accède à l'instance de DBManager
        $this->db = DBManager::getInstance();
    }

    // Méthodes pour gérer les utilisateurs
    public function emailExists(string $email): bool {
        $sql="SELECT COUNT(*) FROM users WHERE email = ?";
        
        $result = $this->db->query($sql,[$email]);
        return $result->fetchColumn()> 0;


        
    }

    public function usernameExists(string $username): bool {
        $sql="SELECT COUNT(*) FROM users WHERE username = ?";
        $params = [ $username];

        $result = $this->db->query($sql,$params);

        return $result->fetchColumn()> 0;


    }

    public function validateUserDataLogin(string $email, string $password): array {
        $errors = [];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Veuillez fournir une adresse email valide.";
        }

        if (empty($password)) {
            $errors[] = "Veuillez fournir un mot de passe.";
        }

        return $errors;
    }

    public function createUser(string $username, string $email, string $password): void {
        $sql="INSERT INTO users (username, email, password, user_creation_date) 
            VALUES (?, ?, ?, NOW())";
        $result = $this->db->query($sql,[$username, $email, password_hash($password, PASSWORD_BCRYPT)]);
        
    }

    
    public function findUserByEmail(string $email): ?User {
        // Préparation de la requête SQL pour récupérer l'utilisateur par son email
        $sql = "SELECT * FROM users WHERE email = ?";
        
        // Exécution de la requête avec l'email comme paramètre.
        $result = $this->db->query($sql, [$email]);
                
        $userData = $result->fetch(PDO::FETCH_ASSOC);

       
        return $userData ? $this->mapToUser($userData) : null;
    }


    
    public function findUserById(int $idUser): ?User {
        $sql = "SELECT * FROM users WHERE id_user = :id";
        
        $userData = $this->db->query($sql, [':id' => $idUser])->fetch();
        return $userData ? $this->mapToUser($userData) : null;
    }


    public function updateUserImagePath(int $idUser, string $imagePath): void {
        $sql= "UPDATE users SET image_path = ? WHERE id_user = ?" ;
        $params = [$imagePath, $idUser];
        $result= $this->db->query($sql, $params);

    }

    public function getUserImagePath(int $idUser): string {
        $sql = "SELECT image_path FROM users WHERE id_user = ?";
        $params = [$idUser];
        $result = $this->db->query($sql,$params);
        return $result->fetchColumn() ?? 'uploads/users/defaultAvatar.png';
    }

    private function mapToUser(array $data): User {
        $user = new User();
        $user->setIdUser($data['id_user']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setDateCreationUser($data['user_creation_date']);
        $user->setImagePathUser($data['image_path'] ?? 'uploads/users/defaultAvatar.png');
        return $user;
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

    public function updateUser(User $user): bool
{
    $sql = 'UPDATE users 
            SET email = :email, 
                username = :username, 
                password = :password, 
                image_path = :image_path
                
            WHERE id_user = :id_user';

    $params = [
        ':email' => $user->getEmail(),
        ':username' => $user->getUsername(),
        ':password' => $user->getPassword(),
        ':image_path' => $user->getImagePathUser(),
        ':id_user' => $user->getIdUser(),
    ];

    // Utilisation de la méthode query avec paramètres nommés
    $stmt = $this->db->query($sql, $params);

    // Retourne vrai si l'exécution de la requête a réussi
    return $stmt->rowCount() > 0;
}


}