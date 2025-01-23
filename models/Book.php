<?php

/** Entité représentant les livres disponibles à l'échange. */

class Book extends AbstractEntity
{
    private int $idBook;
    private string $title;
    private string $authorName;
    private string $imagePath;
    private string $description;
    private int $ownerId;
    private ?string $ownerName; // Ajout de la propriété pour le nom du propriétaire
    private ?DateTime $creationDate;
    private ?DateTime $updateDate;
    private bool $isAvailable;

    public function __construct(array $data = [])
    {
        // Initialisation avec les données fournies
        $this->idBook = $data['id_book'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->authorName = $data['author_name'] ?? '';
        $this->imagePath = $data['image_path'] ?? 'uploads/books/defaultBook.png';
        $this->description = $data['description'] ?? '';
        $this->ownerId = $data['owner_id'] ?? 0;
        $this->ownerName = $data['owner_name'] ?? null; // Initialisation du nom du propriétaire
        $this->isAvailable = $data['is_available'] ?? 0;

        // Conversion des dates en objets DateTime
        $this->creationDate = isset($data['creation_date']) 
            ? new DateTime($data['creation_date']) 
            : null;

        $this->updateDate = isset($data['update_date']) && $data['update_date'] !== null
            ? new DateTime($data['update_date'])
            : null;
    }

    // Getter et Setter pour l'id du livre
    public function setIdBook(int $idBook): void
    {
        $this->idBook = $idBook;
    }

    public function getIdBook(): int
    {
        return $this->idBook;
    }

    // Getter et Setter pour le titre
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    // Getter et Setter pour le nom de l'auteur
    public function setAuthorName(string $authorName): void
    {
        $this->authorName = $authorName;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    // Getter et Setter pour l'imagePath
    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    // Getter et Setter pour la description
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    // Getter et Setter pour l'ID du propriétaire
    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    // **Ajout : Getter et Setter pour le nom du propriétaire**
    public function setOwnerName(?string $ownerName): void
    {
        $this->ownerName = $ownerName;
    }

    public function getOwnerName(): ?string
    {
        return $this->ownerName;
    }

    // Getter et Setter pour la date de création
    public function setCreationDate(string|DateTime $creationDate, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($creationDate)) {
            $creationDate = DateTime::createFromFormat($format, $creationDate);
        }
        $this->creationDate = $creationDate;
    }

    public function getCreationDate(): ?DateTime
    {
        return $this->creationDate;
    }

    // Getter et Setter pour la date de mise à jour
    public function setUpdateDate(string|DateTime|null $updateDate, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($updateDate)) {
            $updateDate = DateTime::createFromFormat($format, $updateDate);
        }
        $this->updateDate = $updateDate;
    }

    public function getUpdateDate(): ?DateTime
    {
        return $this->updateDate;
    }

    // Getter et Setter pour la disponibilité du livre
    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }
}
