<?php
/**
 * Classe UserManager
 *
 * Cette classe étend AbstractEntityManager et gère toutes les opérations relatives aux utilisateurs,
 * telles que la vérification de l'existence d'un email ou d'un pseudo, la validation des données de connexion,
 * la création, la recherche et la mise à jour des utilisateurs.
 */
class UserManager extends AbstractEntityManager
{
    /**
     * Constructeur
     *
     * Accède à l'instance de DBManager pour initialiser la connexion à la base de données.
     */
    public function __construct() {
        // Même si AbstractEntityManager initialise déjà $this->db, nous assurons ici d'utiliser l'instance de DBManager.
        $this->db = DBManager::getInstance();
    }

    /**
     * Vérifie si un email existe déjà dans la base de données.
     *
     * @param string $email L'adresse email à vérifier.
     * @return bool Vrai si l'email existe, sinon faux.
     */
    public function emailExists(string $email): bool {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $result = $this->db->query($sql, [$email]);
        return $result->fetchColumn() > 0;
    }

    /**
     * Vérifie si un pseudo (username) existe déjà dans la base de données.
     *
     * @param string $username Le pseudo à vérifier.
     * @return bool Vrai si le pseudo existe, sinon faux.
     */
    public function usernameExists(string $username): bool {
        $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
        $params = [$username];
        $result = $this->db->query($sql, $params);
        return $result->fetchColumn() > 0;
    }

    /**
     * Valide les données de connexion d'un utilisateur.
     *
     * @param string $email L'adresse email saisie.
     * @param string $password Le mot de passe saisi.
     * @return array Tableau des messages d'erreur (vide si aucune erreur).
     */
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

    /**
     * Crée un nouvel utilisateur dans la base de données.
     *
     * @param string $username Le pseudo de l'utilisateur.
     * @param string $email L'adresse email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur (haché).
     * @return void
     */
    public function createUser(string $username, string $email, string $password): void {
        $sql = "INSERT INTO users (username, email, password, user_creation_date) 
                VALUES (?, ?, ?, NOW())";
        $this->db->query($sql, [$username, $email, $password]);
    }

    /**
     * Recherche un utilisateur par son adresse email.
     *
     * @param string $email L'adresse email à rechercher.
     * @return User|null L'objet User correspondant ou null si non trouvé.
     */
    public function findUserByEmail(string $email): ?User {
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $this->db->query($sql, [$email]);
        $userData = $result->fetch(PDO::FETCH_ASSOC);
        return $userData ? $this->mapToUser($userData) : null;
    }

    /**
     * Recherche un utilisateur par son identifiant.
     *
     * Sélectionne quelques colonnes essentielles pour la gestion.
     *
     * @param int $idUser L'identifiant de l'utilisateur.
     * @return User|null L'objet User correspondant ou null si non trouvé.
     */
    public function findUserById(int $idUser): ?User {
        // Tout sélectionner (ou au moins email et password)
        $sql = "SELECT id_user, username, email, password, image_path, user_creation_date 
                FROM users 
                WHERE id_user = :idUser";
    
        $result = $this->db->query($sql, [':idUser' => $idUser]);
        $userData = $result->fetch(PDO::FETCH_ASSOC);
    
        if ($userData) {
            $user = new User();
            $user->setIdUser($userData['id_user']);
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
            $user->setImagePathUser($userData['image_path'] ?? 'uploads/users/defaultAvatar.png');
    
            if (!empty($userData['user_creation_date'])) {
                $user->setDateCreationUser(new DateTime($userData['user_creation_date']));
            } else {
                $user->setDateCreationUser(null);
            }
            return $user;
        }
        return null;
    }
    

    /**
     * Met à jour l'image de profil d'un utilisateur.
     *
     * Supprime l'ancienne image si elle n'est pas la valeur par défaut et met à jour le chemin dans la base de données.
     *
     * @param int $idUser L'identifiant de l'utilisateur.
     * @param string $newImagePath Le nouveau chemin de l'image.
     * @return void
     */
    public function updateUserImagePath(int $idUser, string $newImagePath): void {
        // Récupère le chemin de l'image actuelle
        $currentImagePath = $this->getUserImagePath($idUser);
        // Supprime l'ancienne image si ce n'est pas l'image par défaut et si le fichier existe
        if ($currentImagePath !== 'uploads/users/defaultAvatar.png' && file_exists($currentImagePath)) {
            unlink($currentImagePath);
        }
        // Met à jour le chemin de l'image dans la base de données
        $sql = "UPDATE users SET image_path = ? WHERE id_user = ?";
        $this->db->query($sql, [$newImagePath, $idUser]);
    }

    /**
     * Récupère le chemin de l'image de profil d'un utilisateur.
     *
     * @param int $idUser L'identifiant de l'utilisateur.
     * @return string Le chemin de l'image ou la valeur par défaut si non défini.
     */
    public function getUserImagePath(int $idUser): string {
        $sql = "SELECT image_path FROM users WHERE id_user = ?";
        $params = [$idUser];
        $result = $this->db->query($sql, $params);
        return $result->fetchColumn() ?? 'uploads/users/defaultAvatar.png';
    }

    /**
     * Mappe un tableau associatif en un objet User.
     *
     * @param array $data Les données de l'utilisateur.
     * @return User L'objet User correspondant.
     */
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

    /**
     * Valide les données d'inscription d'un utilisateur.
     *
     * Vérifie le format de l'email, la présence du pseudo et la longueur du mot de passe.
     * Vérifie également l'unicité de l'email et du pseudo.
     *
     * @param mixed $email L'adresse email.
     * @param mixed $username Le pseudo (facultatif).
     * @param mixed $password Le mot de passe (facultatif).
     * @return array Tableau des messages d'erreur (vide si aucune erreur).
     */
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

        // Vérifie l'unicité de l'email et du pseudo
        if ($this->emailExists($email)) {
            $errors[] = "Cet email est déjà utilisé.";
        }

        if ($username && $this->usernameExists($username)) {
            $errors[] = "Ce pseudo est déjà utilisé.";
        }

        return $errors;
    }

    /**
     * Met à jour les informations d'un utilisateur dans la base de données.
     *
     * @param User $user L'objet User contenant les informations mises à jour.
     * @return bool Vrai si la mise à jour a réussi (au moins une ligne affectée), sinon faux.
     */
    public function updateUser(User $user): bool {
        $sql = 'UPDATE users 
                SET email = :email, 
                    username = :username, 
                    password = :password, 
                    image_path = :image_path
                WHERE id_user = :id_user';

        $params = [
            ':email'       => $user->getEmail(),
            ':username'    => $user->getUsername(),
            ':password'    => $user->getPassword(),
            ':image_path'  => $user->getImagePathUser(),
            ':id_user'     => $user->getIdUser(),
        ];

        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount() > 0;
    }

    /**
     * Récupère les informations d'un utilisateur sous forme de tableau associatif.
     *
     * Sélectionne l'ID, le pseudo et le chemin de l'image.
     *
     * @param int $userId L'identifiant de l'utilisateur.
     * @return array|null Tableau associatif contenant les informations ou null si non trouvé.
     */
    public function getUserInfoById($userId) {
        $sql = "SELECT id_user, username, image_path FROM users WHERE id_user = :userId";
        $params = ['userId' => $userId];
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
