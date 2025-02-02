<?php

    /**
     * Classe BookManager
     * Cette classe gère toutes les opérations relatives aux livres dans la base de données.
     */
    class BookManager extends AbstractEntityManager {

    
        public function getAllBooks(): array
{
    $sql = "SELECT 
                b.*, 
                u.username AS owner_name 
            FROM 
                books b
            JOIN 
                users u 
            ON 
                b.owner_id = u.id_user
";
    $query = $this->db->query($sql);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Conversion en objets Book
    $books = [];
    foreach ($result as $row) {
        $books[] = new Book($row);
    }

    return $books;
}

public function getLastAddedBooks() {
    $sql = "SELECT b.*, u.username AS owner_name
            FROM books b
            JOIN users u ON b.owner_id = u.id_user
            ORDER BY b.creation_date DESC
            LIMIT 4";
    $query = $this->db->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Affiche les résultats SQL
    // var_dump($results);
    // exit;

    $books = [];
    foreach ($results as $result) {
        $books[] = new Book($result);
    }

    return $books;
}


public function findBookByTitle(string $title): ?Book
{
    $sql = "SELECT * FROM books WHERE title LIKE :title LIMIT 1";
    $params = [':title' => '%' . $title . '%'];
    $stmt = $this->db->query($sql, $params);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data ? new Book($data) : null;
}

public function searchBooksByTitleOrAuthor(string $searchTerm): array {
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


public function getBookByIdBook(int $id): ?Book
{
    $sql = "SELECT * FROM books WHERE id_book = :id_book";
    $params = [':id_book' => $id];
    $query = $this->db->query($sql, $params); 
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result ? new Book($result) : null;
}

public function mapToBook(array $data): Book {
    $book = new Book();
    
    $book->setIdBook($data['id_book']);
    $book->setTitle($data['title']);
    $book->setAuthorName($data['author_name']);
    $book->setImagePath($data['image_path']);
    $book->setDescription($data['description']);
    $book->setOwnerId($data['owner_id']);
    $book->setIsAvailable($data['is_available']);
    
    // Vérifier si creation_date est valide
    if (!empty($data['creation_date'])) {
        try {
            $book->setCreationDate(new DateTime($data['creation_date']));
        } catch (Exception $e) {
            $book->setCreationDate(null); // Affecte null en cas de problème
        }
    } else {
        $book->setCreationDate(null); // Affecte null si creation_date est NULL
    }

    // Vérifier si update_date est valide
    if (!empty($data['update_date'])) {
        try {
            $book->setUpdateDate(new DateTime($data['update_date']));
        } catch (Exception $e) {
            $book->setUpdateDate(null); // Affecte null en cas de problème
        }
    } else {
        $book->setUpdateDate(null); // Affecte null si update_date est NULL
    }

    return $book;
}




        /**
        * Méthode pour récupérer tous les livres appartenant à un utilisateur spécifique.
        */
        public function findBooksByUserId(int $ownerId): array
{
    $sql = "SELECT * FROM books WHERE owner_id = :ownerId";
    $params = [':ownerId' => $ownerId];
    
    // Récupérer les résultats en tableau associatif
    $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC) ?: [];
    
    // Transformer chaque ligne en objet Book
    $books = [];
    foreach ($result as $data) {
        $books[] = new Book($data);
    }

    return $books;
}

public function findBookById(int $bookId): ?Book
{
    $sql = "SELECT * FROM books WHERE id_book = :id_book";
    
    // Utilisation de la méthode query de DBManager pour exécuter la requête
    $stmt = $this->db->query($sql, ['id_book' => $bookId]);
    
    // Récupération du résultat
    $bookData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si un résultat est trouvé, on retourne un objet Book, sinon null
    return $bookData ? new Book($bookData) : null;
}

        
public function findBooksByOwnerId($ownerId) {
    $sql = "SELECT * FROM books WHERE owner_id = :owner_id";
    $params = [':owner_id' => $ownerId]; // Définir les paramètres

    // Utiliser votre méthode query pour exécuter la requête
    $statement = $this->db->query($sql, $params);

    $books = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $books[] = $this->mapToBook($row); // Mapper les résultats en objets Book
    }

    return $books; // Retourne le tableau d'objets Book
}




        

        /**
         * Compte le nombre de livres d'un utilisateur.
         * 
         * @param int $userId ID de l'utilisateur.
         * @return int Nombre de livres appartenant à l'utilisateur.
         */
        public static function getUserBookCount(int $userId): int {
            $bookManager = new BookManager();
            $books = $bookManager->findBooksByUserId($userId);
            return count($books); // Retourne le nombre total de livres
        }
   
        public function createBook(Book $book)
{
    $sql = "INSERT INTO books (title, author_name, description, owner_id, is_available, image_path, creation_date, update_date)
            VALUES (:title, :author_name, :description, :owner_id, :is_available, :image_path, NOW(), NOW())";

    $params = [
        ':title' => $book->getTitle(),
        ':author_name' => $book->getAuthorName(),
        ':description' => $book->getDescription(),
        ':owner_id' => $book->getOwnerId(),
        ':is_available' => $book->getIsAvailable(),
        ':image_path' => $book->getImagePath(),
        
    ];

    $this->db->query($sql, $params); 
}

    
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
            ':title' => $book->getTitle(),
            ':author_name' => $book->getAuthorName(),
            ':description' => $book->getDescription(),
            ':is_available' => $book->getIsAvailable(),
            ':image_path' => $book->getImagePath(),
            ':id_book' => $book->getIdBook(),
        ];

        $this->db->query($sql, $params);
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour du livre : " . $e->getMessage());
        throw $e; // Vous pouvez relancer ou gérer l'exception ici
    }
}



public function deleteBook(int $bookId): void
{
    $sql = "DELETE FROM books WHERE id_book = :id_book";
    $this->db->query($sql, ['id_book' => $bookId]);
}

        public function deleteBookWithImage(int $id, int $userId): bool {
            try {
                $book = $this->findBookById($id);
                if ($book && $book->getOwnerId() === $userId) {
                    $imagePath = $book->getImagePath();
                    if ($imagePath !== 'uploads/books/defaultBook.png' && file_exists(__DIR__ . '/../../' . $imagePath)) {
                        unlink(__DIR__ . '/../../' . $imagePath);
                    }
                    return $this->deleteBook($id, $userId);
                }
            } catch (Exception $e) {
                error_log("Erreur lors de la suppression du livre : " . $e->getMessage());
            }
        
            return false;
        }
        
}