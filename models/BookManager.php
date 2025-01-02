<?php

class BookManager extends AbstractEntityManager {

public function getBookMessage() :string {
        $sql = "SELECT author_name FROM books";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['author_name'] ?? 'Hello me (par défaut)'; // Sélectionner le nom de champ de la BDD
    }
  
    public function findBooksByUserId(int $ownerId)
    {
        $sql = "SELECT * FROM books WHERE owner_id = :ownerId";
        $params = [':ownerId' => $ownerId];
        return $this->db->query($sql, $params)->fetchAll();
    }

    // Méthode pour récupérer un livre par son ID
public function getBookById($id)
{
    $sql = "SELECT * FROM books WHERE id_books = :id";
    $params = [':id' => $id];
    return $this->db->query($sql, $params)->fetch();
}


    public function createBook($title, $author_name, $description, $owner_id, $is_available) {
        // Récupération de l'instance de DBManager
        $db = DBManager::getInstance()->getPDO();

        // Requête SQL pour insérer un livre
        $sql = "INSERT INTO books (title, author_name, description, owner_id, is_available, creation_date, update_date)
                VALUES (:title, :author_name, :description, :owner_id, :is_available, NOW(), NOW())";

        // Préparation de la requête
        $stmt = $db->prepare($sql);

        // Exécution de la requête avec les paramètres
        $stmt->execute([
            ':title' => $title,
            ':author_name' => $author_name,
            ':description' => $description,
            ':owner_id' => $owner_id,
            ':is_available' => $is_available,
        ]);
    }
    
    // Méthode pour mettre à jour un livre
public function updateBook($id, $title, $author, $description, $isAvailable)
{
    $sql = "UPDATE books 
            SET title = :title, author_name = :author, description = :description, is_available = :isAvailable, update_date = NOW() 
            WHERE id_books = :id";
    
    $params = [
        ':id' => $id,
        ':title' => $title,
        ':author' => $author,
        ':description' => $description,
        ':isAvailable' => $isAvailable
    ];
    
    $this->db->query($sql, $params);
}

public function getLimitedBooks($limit = 4)
{
    $sql = "SELECT * FROM books ORDER BY creation_date DESC LIMIT :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Récupérer tous les livres
public function getAllBooks() {
    $query = $this->db->query("SELECT * FROM books");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

}