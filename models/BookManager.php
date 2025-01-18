<?php

    /**
     * Classe BookManager
     * Cette classe gère toutes les opérations relatives aux livres dans la base de données.
     */
    class BookManager extends AbstractEntityManager {

    
        /**
         * Méthode pour récupérer tous les livres présents dans la base de données.
         * 
         * @return array Liste de tous les livres.
         */
        public function getAllBooks(): array
{
    $query = $this->db->query("SELECT * FROM books");
    $books = [];
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $books[] = new Book($row);
    }
    return $books;
}


        public function getBookById($id)
{
    $db = DBManager::getInstance()->getPDO();
    $sql = "SELECT * FROM books WHERE id_book = :id_book";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id_book' => $id]);

    $bookData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bookData) {
        $book = new Book();
        $book->setIdBook($bookData['id_book']);
        $book->setTitle($bookData['title']);
        $book->setAuthorName($bookData['author_name']);
        $book->setDescription($bookData['description']);
        $book->setIsAvailable($bookData['is_available']);
        $book->setImagePath($bookData['image_path']);
        return $book;
    }

    return null; // Aucun livre trouvé
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
    foreach ($result as $row) {
        $books[] = new Book($row);
    }

    return $books;
}

        /**
         * Méthode pour récupérer les détails d'un livre à partir de son ID.
        
         */
        public function findBookById(int $bookId): ?Book
{
    $sql = "SELECT * FROM books WHERE id_book = :id_book";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id_book' => $bookId]);
    $bookData = $stmt->fetch(PDO::FETCH_ASSOC);

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
   
        /**
         * Méthode pour ajouter un livre, en utilisant l'objet Book
         */
        public function createBook(Book $book) {
            try {
                $db = DBManager::getInstance()->getPDO();
                $sql = "INSERT INTO books (title, author_name, description, owner_id, is_available, image_path, creation_date, update_date)
                        VALUES (:title, :author_name, :description, :owner_id, :is_available, :image_path, NOW(), NOW())";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':title' => $book->getTitle(),
                    ':author_name' => $book->getAuthorName(),
                    ':description' => $book->getDescription(),
                    ':owner_id' => $book->getOwnerId(),
                    ':is_available' => $book->getIsAvailable(),
                    ':image_path' => $book->getImagePath(),
                ]);
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de l'ajout du livre : " . $e->getMessage());
            }
        }
    
        /**
         * Méthode pour mettre à jour un livre existant.
         * 
         * @param Book $book L'objet Book contenant les informations à mettre à jour.
         */
        public function updateBook(Book $book)
        {
            try {
                // Récupérer la connexion à la base de données
                $db = DBManager::getInstance()->getPDO();

                // Requête SQL de mise à jour
                $sql = "UPDATE books 
                        SET title = :title, 
                            author_name = :author_name, 
                            description = :description, 
                            is_available = :is_available, 
                            image_path = :image_path, 
                            update_date = NOW() 
                        WHERE id_book = :id_book";
                
                // Préparation et exécution de la requête avec les paramètres
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':title' => $book->getTitle(),
                    ':author_name' => $book->getAuthorName(),
                    ':description' => $book->getDescription(),
                    ':is_available' => $book->getIsAvailable(),
                    ':image_path' => $book->getImagePath(),
                    ':id_book' => $book->getId(), 
                ]);
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la mise à jour du livre : " . $e->getMessage());
            }
        }

        /**
         * Méthode pour supprimer un livre de la base de données en fonction de son ID,
         * uniquement si l'utilisateur est le propriétaire du livre.
        */
        public function deleteBookById(int $bookId): bool
        {
            $sql = "DELETE FROM books WHERE id_book = :id_book";
            $statement = $this->db->prepare($sql);
            return $statement->execute(['id_book' => $bookId]);
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