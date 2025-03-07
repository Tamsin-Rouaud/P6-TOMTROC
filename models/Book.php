<?php
/**
 * Entité représentant les livres disponibles à l'échange.
 *
 * Cette classe hérite d'AbstractEntity et modélise un livre avec ses propriétés
 * telles que le titre, l'auteur, l'image, la description, le propriétaire, etc.
 */
class Book extends AbstractEntity
{
    // Attributs privés de l'entité Book
    private int $idBook;
    private string $title;
    private string $authorName;
    private string $imagePath;
    private string $description;
    private int $ownerId;
    private ?string $ownerName; // Nom du propriétaire (optionnel)
    private ?DateTime $creationDate;
    private ?DateTime $updateDate;
    private bool $isAvailable;

    /**
     * Constructeur de la classe Book.
     *
     * Initialise les attributs avec les données fournies dans le tableau associatif.
     * Si une clé n'est pas présente, une valeur par défaut est utilisée.
     *
     * @param array $data Tableau associatif contenant les données du livre.
     */
    public function __construct(array $data = [])
    {
        // Initialisation des propriétés avec les données fournies
        $this->idBook      = $data['id_book'] ?? 0;
        $this->title       = $data['title'] ?? '';
        $this->authorName  = $data['author_name'] ?? '';
        $this->imagePath   = $data['image_path'] ?? 'uploads/books/defaultBook.png';
        $this->description = $data['description'] ?? '';
        $this->ownerId     = $data['owner_id'] ?? 0;
        $this->ownerName   = $data['owner_name'] ?? null;
        $this->isAvailable = $data['is_available'] ?? 0;

        // Conversion des dates en objets DateTime, si elles sont fournies
        $this->creationDate = isset($data['creation_date'])
            ? new DateTime($data['creation_date'])
            : null;

        $this->updateDate = (isset($data['update_date']) && $data['update_date'] !== null)
            ? new DateTime($data['update_date'])
            : null;
    }

    // --- Getters et Setters ---

    /**
     * Définit l'identifiant du livre.
     *
     * @param int $idBook
     * @return void
     */
    public function setIdBook(int $idBook): void
    {
        $this->idBook = $idBook;
    }

    /**
     * Récupère l'identifiant du livre.
     *
     * @return int
     */
    public function getIdBook(): int
    {
        return $this->idBook;
    }

    /**
     * Définit le titre du livre.
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Récupère le titre du livre.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Définit le nom de l'auteur.
     *
     * @param string $authorName
     * @return void
     */
    public function setAuthorName(string $authorName): void
    {
        $this->authorName = $authorName;
    }

    /**
     * Récupère le nom de l'auteur.
     *
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * Définit le chemin de l'image associée au livre.
     *
     * @param string $imagePath
     * @return void
     */
    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Récupère le chemin de l'image associée au livre.
     *
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * Définit la description du livre.
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Récupère la description du livre.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Définit l'identifiant du propriétaire du livre.
     *
     * @param int $ownerId
     * @return void
     */
    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    /**
     * Récupère l'identifiant du propriétaire du livre.
     *
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * Définit le nom du propriétaire du livre.
     *
     * @param string|null $ownerName
     * @return void
     */
    public function setOwnerName(?string $ownerName): void
    {
        $this->ownerName = $ownerName;
    }

    /**
     * Récupère le nom du propriétaire du livre.
     *
     * @return string|null
     */
    public function getOwnerName(): ?string
    {
        return $this->ownerName;
    }

    /**
     * Définit la date de création du livre.
     *
     * Accepte une chaîne de caractères ou un objet DateTime. Si une chaîne est fournie,
     * elle est convertie en objet DateTime selon le format spécifié.
     *
     * @param string|DateTime $creationDate
     * @param string $format
     * @return void
     */
    public function setCreationDate(string|DateTime $creationDate, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($creationDate)) {
            $creationDate = DateTime::createFromFormat($format, $creationDate);
        }
        $this->creationDate = $creationDate;
    }

    /**
     * Récupère la date de création du livre.
     *
     * @return DateTime|null
     */
    public function getCreationDate(): ?DateTime
    {
        return $this->creationDate;
    }

    /**
     * Définit la date de mise à jour du livre.
     *
     * Accepte une chaîne, un objet DateTime ou null. La chaîne est convertie en objet DateTime.
     *
     * @param string|DateTime|null $updateDate
     * @param string $format
     * @return void
     */
    public function setUpdateDate(string|DateTime|null $updateDate, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($updateDate)) {
            $updateDate = DateTime::createFromFormat($format, $updateDate);
        }
        $this->updateDate = $updateDate;
    }

    /**
     * Récupère la date de mise à jour du livre.
     *
     * @return DateTime|null
     */
    public function getUpdateDate(): ?DateTime
    {
        return $this->updateDate;
    }

    /**
     * Définit la disponibilité du livre.
     *
     * @param bool $isAvailable
     * @return void
     */
    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    /**
     * Récupère la disponibilité du livre.
     *
     * @return bool
     */
    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }
}
