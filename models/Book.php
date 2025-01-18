<?php

/** Entité représentant les livres disponible à l'échange. */

    class Book extends AbstractEntity
    {
        private int $idBook;
        private string $title;
        private string $authorName;
        private string $imagePath;
        private string $description;
        private int $ownerId;
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
        $this->isAvailable = $data['is_available'] ?? 0;
        // Conversion des dates en objets DateTime
        $this->creationDate = isset($data['creation_date']) 
            ? new DateTime($data['creation_date']) 
            : null;
        $this->updateDate = isset($data['update_date']) && $data['update_date'] !== null
            ? new DateTime($data['update_date'])
            : null;
        
    }

    // Exemple de getter
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }


        /**
         * Setter pour l'id du livre
         * @param int $idBook
         * @return void
         */
        public function setIdBook(int $idBook): void
        {
            $this->idBook = $idBook;
        }

        /**
         * Getter pour l'id du livre
         * @return int
         */
        public function getIdBook(): int
        {
            return $this->idBook;
        }


        /**
         * Setter pour le titre.
         * @param string $title
         */
        public function setTitle(string $title) : void 
        {
            $this->title = $title;
        }

        /**
         * Getter pour le titre.
         * @return string
         */
        public function getTitle() : string 
        {
            return $this->title;
        }


        /**
         * Setter pour le le nom de l'auteur.
         * @param string $authorName
         */
        public function setAuthorName(string $authorName) : void 
        {
            $this->authorName = $authorName;
        }

        /**
         * Getter pour le nom de l'auteur.
         * @return string
         */
        public function getAuthorName() : string 
        {
            return $this->authorName;
        }


        /**
         * Setter pour l'imagePath.
         * @param string $imagePath
         */
        public function setImagePath(string $imagePath) : void 
        {
            $this->imagePath = $imagePath;
        }

        /**
         * Getter pour l'imagePath.
         * @return string
         */
        public function getImagePath() : string 
        {
            return $this->imagePath;
        }


        /**
         * Setter pour la description.
         * @param string $description
         */
        public function setDescription(string $description) : void 
        {
            $this->description = $description;
        }

        /**
         * Getter pour la description.
         * @return string
         */
        public function getDescription() : string 
        {
            return $this->description;
        }


       

        /**
         * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
         * @param string|DateTime $creationDate
         * @param string $format : le format pour la convertion de la date si elle est une string.
         * Par défaut, c'est le format de date mysql qui est utilisé. 
         */
        public function setCreationDate(string|DateTime $creationDate, string $format = 'Y-m-d H:i:s') : void 
        {
            if (is_string($creationDate)) {
                $creationDate = DateTime::createFromFormat($format, $creationDate);
            }
            $this->creationDate = $creationDate;
        }

        /**
         * Getter pour la date de création.
         * @return DateTime
         */
        public function getCreationDate() : DateTime 
        {
            return $this->creationDate;
        }


        /** Setter pour la date de mise à jour. Si la date est une string, on la convertit en DateTime.
         * @param string|DateTime $updateDate
         * @param string $format : le format pour la convertion de la date si elle est une string.
         * Par défaut, c'est le format de date mysql qui est utilisé.
         */
            public function setUpdateDate(string|DateTime|null $updateDate, string $format = 'Y-m-d H:i:s') : void 
            {
                if (is_string($updateDate)) {
                    $updateDate = DateTime::createFromFormat($format, $updateDate);
                }
                $this->updateDate = $updateDate;
            }

        /**
         * Getter pour la date de mise à jour.
         * Grâce au setter, on a la garantie de récupérer un objet DateTime ou null
         * si la date de mise à jour n'a pas été définie.
         * @return DateTime|null
         */
        public function getUpdateDate() : ?DateTime 
        {
            return $this->updateDate;
        }
        

        /**
         * Setter pour la disponibilité du livre.
         * @param bool $isAvailable
         * @return void
         */
        public function setIsAvailable(bool $isAvailable): void
        {
            $this->isAvailable = $isAvailable;
        }

        /**
         * Getter pour la disponibilité du livre.
         * @return bool
         */
        public function getIsAvailable(): bool 
        {
            return $this->isAvailable;
        }
    
    }