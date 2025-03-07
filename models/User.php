<?php
/**
 * Entité représentant un utilisateur.
 *
 * Cette classe hérite d'AbstractEntity et définit les propriétés d'un utilisateur,
 * telles que l'identifiant, le nom, l'email, le mot de passe, le chemin de l'image de profil
 * et la date de création du compte.
 */
class User extends AbstractEntity
{
    // Propriétés de l'utilisateur
    private int $idUser;
    private string $username ;
    private string $email ;
    private string $password ;
    private string $imagePathUser ;
    private ?DateTime $dateCreationUser = null;

    /**
     * Constructeur de la classe User.
     *
     * Accepte un tableau associatif pour hydrater l'objet avec ses propriétés.
     *
     * @param array $data Tableau associatif contenant les données de l'utilisateur.
     */
    public function __construct(array $data = [])
    {
        // Appelle le constructeur de la classe parente pour initialiser l'hydratation
        parent::__construct();
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Hydrate l'objet avec des données provenant d'un tableau associatif.
     *
     * Cette méthode est déjà implémentée dans AbstractEntity, donc elle est commentée ici.
     *
     * @param array $data Tableau associatif contenant les données de l'utilisateur.
     */
    
    // ----------------- Getters et Setters -----------------

    /**
     * Récupère l'identifiant de l'utilisateur.
     *
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Définit l'identifiant de l'utilisateur.
     *
     * @param int $idUser
     * @return void
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * Récupère le nom d'utilisateur.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Définit le nom d'utilisateur.
     *
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Récupère l'email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Définit l'email.
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Récupère le mot de passe.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Définit le mot de passe.
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Récupère le chemin de l'image de profil.
     *
     * Si aucun chemin n'est défini, retourne un chemin par défaut.
     *
     * @return string
     */
    public function getImagePathUser(): string
    {
        return $this->imagePathUser ?? './uploads/users/defaultAvatar.png';
    }

    /**
     * Définit le chemin de l'image de profil.
     *
     * @param string $imagePathUser
     * @return void
     */
    public function setImagePathUser(string $imagePathUser): void
    {
        $this->imagePathUser = $imagePathUser;
    }

    /**
     * Définit la date de création du compte utilisateur.
     *
     * Accepte une chaîne de caractères, un objet DateTime ou null.
     *
     * @param mixed $date La date de création (chaîne ou DateTime).
     * @return void
     * @throws InvalidArgumentException Si le type de date est invalide.
     */
    public function setDateCreationUser($date): void
    {
        if (is_string($date)) {
            // Convertit une chaîne en objet DateTime
            $this->dateCreationUser = new DateTime($date);
        } elseif ($date instanceof DateTime) {
            // Assigne directement si c'est un objet DateTime
            $this->dateCreationUser = $date;
        } elseif ($date === null || $date === false) {
            // Gère les cas où la valeur est null ou false
            $this->dateCreationUser = null;
        } else {
            // Lève une exception si le type est invalide
            throw new InvalidArgumentException('Invalid type for date creation');
        }
    }

    /**
     * Récupère la date de création du compte utilisateur.
     *
     * Si la date est stockée sous forme de chaîne, elle est convertie en objet DateTime.
     *
     * @return DateTime La date de création.
     * @throws Exception Si le format de la date est invalide.
     */
    public function getDateCreationUser(): DateTime
    {
        if (is_string($this->dateCreationUser)) {
            // ATTENTION : L'ancienne version utilisait $this->user_creation_date,
            // ce qui semble être une erreur. On utilise ici $this->dateCreationUser.
            return new DateTime($this->dateCreationUser);
        }
        if ($this->dateCreationUser instanceof DateTime) {
            return $this->dateCreationUser;
        }
        throw new Exception("Le format de la date de création est invalide.");
    }
}
