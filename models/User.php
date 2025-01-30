<?php

class User extends AbstractEntity
{
    private int $idUser;
    private string $username;
    private string $email;
    private string $password;
    private string $imagePathUser;
    private ?DateTime $dateCreationUser = null;

    /**
     * Constructeur : accepte un tableau associatif pour hydrater l'objet
     */
    public function __construct(array $data = [])
    {
        parent::__construct(); // Appelle le constructeur de la classe parente
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Hydrate l'objet avec des données du tableau associatif
     * @param array $data
     */
    // protected function hydrate(array $data): void
    // {
    //     foreach ($data as $key => $value) {
    //         // Convertit les clés en noms de méthode set (par exemple, 'username' -> 'setUsername')
    //         $method = 'set' . ucfirst($key);

    //         // Appelle le setter correspondant si la méthode existe
    //         if (method_exists($this, $method)) {
    //             $this->$method($value);
    //         }
    //     }
    // }

    // Getters et Setters existants

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getImagePathUser(): string
    {
        return $this->imagePathUser ?? './uploads/users/defaultAvatar.png';
    }

    public function setImagePathUser(string $imagePathUser): void
    {
        $this->imagePathUser = $imagePathUser;
    }

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


public function getDateCreationUser(): DateTime
{
    if (is_string($this->dateCreationUser)) {
        // Convertit la chaîne en objet DateTime
        return new DateTime($this->user_creation_date);
    }
    if ($this->dateCreationUser instanceof DateTime) {
        // Retourne directement si c'est déjà un objet DateTime
        return $this->dateCreationUser;
    }
    throw new Exception("Le format de la date de création est invalide.");
}


}
