<?php
/**
 * Cette classe gère toutes les opérations relatives aux livres dans la base de données.
 * Elle hérite d'AbstractEntityManager et utilise l'instance de DBManager pour exécuter les requêtes.
 */
class BookManager extends AbstractEntityManager {

    /**
     * Crée un nouveau livre dans la base de données.
     *
     * @param Book $book L'objet Book à créer.
     * @return void
     */
    public function createBook(Book $book)
    {
        $sql = "INSERT INTO books (title, author_name, description, owner_id, is_available, image_path, creation_date, update_date)
                VALUES (:title, :author_name, :description, :owner_id, :is_available, :image_path, NOW(), NOW())";

        $params = [
            ':title'         => $book->getTitle(),
            ':author_name'   => $book->getAuthorName(),
            ':description'   => $book->getDescription(),
            ':owner_id'      => $book->getOwnerId(),
            ':is_available'  => $book->getIsAvailable(),
            ':image_path'    => $book->getImagePath(),
        ];

        $this->db->query($sql, $params);
    }

    /**
     * Récupère tous les livres de la base de données.
     *
     * @return array Tableau d'objets Book.
     */
    public function getAllBooks(): array
    {
        $sql = "SELECT b.*, u.username AS owner_name FROM books b
                JOIN users u ON b.owner_id = u.id_user";

        $query = $this->db->query($sql);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Conversion des résultats en objets Book
        $books = [];
        foreach ($result as $row) {
            $books[] = new Book($row);
        }
        return $books;
    }

    /**
     * Met à jour les informations d'un livre existant.
     *
     * @param Book $book L'objet Book contenant les nouvelles informations.
     * @return void
     * @throws PDOException En cas d'erreur lors de l'exécution de la requête.
     */
    public function updateBook(Book $book)
    {
        try {
            $sql = "UPDATE books 
                    SET title = :title, 
                        author_name = :author_name, 
                        description = :description, 
                        is_available = :is_available, 
                        image_path = :image_path, 
                        update_date = NOW() 
                    WHERE id_book = :id_book";

            $params = [
                ':title'        => $book->getTitle(),
                ':author_name'  => $book->getAuthorName(),
                ':description'  => $book->getDescription(),
                ':is_available' => $book->getIsAvailable(),
                ':image_path'   => $book->getImagePath(),
                ':id_book'      => $book->getIdBook(),
            ];

            $this->db->query($sql, $params);
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du livre : " . $e->getMessage());
            throw $e; // Relance ou gère l'exception selon les besoins
        }
    }

    /**
     * Supprime un livre de la base de données.
     *
     * @param int $bookId L'identifiant du livre à supprimer.
     * @return void
     */
    public function deleteBook(int $bookId): void
    {
        $sql = "DELETE FROM books WHERE id_book = :id_book";
        $this->db->query($sql, ['id_book' => $bookId]);
    }

    /**
     * Récupère les 4 derniers livres ajoutés.
     *
     * @return array Tableau d'objets Book.
     */
    public function getLastAddedBooks() 
    {
        $sql = "SELECT b.*, u.username AS owner_name
                FROM books b
                JOIN users u ON b.owner_id = u.id_user
                ORDER BY b.creation_date DESC
                LIMIT 4";
        $query = $this->db->query($sql);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $books = [];
        foreach ($results as $result) {
            $books[] = new Book($result);
        }
        return $books;
    }

    /**
     * Recherche des livres dont le titre ou le nom de l'auteur correspond au terme de recherche.
     *
     * @param string $searchTerm Le terme de recherche.
     * @return array Tableau d'objets Book correspondant aux critères.
     */
    public function searchBooksByTitleOrAuthor(string $searchTerm): array 
    {
        $sql = "
            SELECT b.*, u.username AS owner_name
            FROM books b
            JOIN users u ON b.owner_id = u.id_user
            WHERE b.title LIKE :searchTerm
            OR b.author_name LIKE :searchTerm
        ";

        $params = [':searchTerm' => '%' . $searchTerm . '%'];
        $stmt = $this->db->query($sql, $params);

        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = new Book($row);
        }
        return $books;
    }
    
    /**
     * Mappe un tableau associatif en objet Book.
     *
     * Permet de convertir les données d'une requête SQL en un objet Book.
     *
     * @param array $data Les données du livre.
     * @return Book L'objet Book correspondant.
     */
    public function mapToBook(array $data): Book 
    {
        $book = new Book();
        $book->setIdBook($data['id_book']);
        $book->setTitle($data['title']);
        $book->setAuthorName($data['author_name']);
        $book->setImagePath($data['image_path']);
        $book->setDescription($data['description']);
        $book->setOwnerId($data['owner_id']);
        $book->setIsAvailable($data['is_available']);
        
        // Gestion de la date de création
        if (!empty($data['creation_date'])) {
            try {
                $book->setCreationDate(new DateTime($data['creation_date']));
            } catch (Exception $e) {
                $book->setCreationDate(null);
            }
        } else {
            $book->setCreationDate(null);
        }

        // Gestion de la date de mise à jour
        if (!empty($data['update_date'])) {
            try {
                $book->setUpdateDate(new DateTime($data['update_date']));
            } catch (Exception $e) {
                $book->setUpdateDate(null);
            }
        } else {
            $book->setUpdateDate(null);
        }
        return $book;
    }

    /**
     * Récupère tous les livres appartenant à un utilisateur spécifique.
     *
     * @param int $ownerId L'identifiant du propriétaire.
     * @return array Tableau d'objets Book.
     */
    public function findBooksByUserId(int $ownerId): array
    {
        $sql = "SELECT * FROM books WHERE owner_id = :ownerId";
        $params = [':ownerId' => $ownerId];
        
        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC) ?: [];
        
        $books = [];
        foreach ($result as $data) {
            $books[] = new Book($data);
        }
        return $books;
    }

    /**
     * Récupère un livre à partir de son identifiant.
     *
     * @param int $bookId L'identifiant du livre.
     * @return Book|null L'objet Book correspondant ou null si non trouvé.
     */
    public function findBookById(int $bookId): ?Book
    {
        $sql = "SELECT * FROM books WHERE id_book = :id_book";
        $stmt = $this->db->query($sql, ['id_book' => $bookId]);
        $bookData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $bookData ? new Book($bookData) : null;
    }

    /**
     * Compte le nombre de livres appartenant à un utilisateur.
     *
     * @param int $userId ID de l'utilisateur.
     * @return int Nombre total de livres de l'utilisateur.
     */
    public static function getUserBookCount(int $userId): int {
        $bookManager = new BookManager();
        $books = $bookManager->findBooksByUserId($userId);
        return count($books);
    }
}
