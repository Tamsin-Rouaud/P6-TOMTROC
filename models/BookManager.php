<?php

    /**
     * Classe BookManager
     * Cette classe gère toutes les opérations relatives aux livres dans la base de données.
     */
    class BookManager extends AbstractEntityManager {

    
        public function getAllBooks(): array
{
    $sql = "SELECT * FROM books";
    $query = $this->db->query($sql);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Conversion en objets Book
    $books = [];
    foreach ($result as $row) {
        $books[] = new Book($row);
    }

    return $books;
}



public function getBookById(int $id): ?Book
{
    $sql = "SELECT * FROM books WHERE id_book = :id_book";
    $params = [':id_book' => $id];
    $query = $this->db->query($sql, $params); 
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result ? new Book($result) : null;
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