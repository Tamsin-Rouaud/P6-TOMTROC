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
        public function getAllBooks() {
            $query = $this->db->query("SELECT * FROM books"); 
            return $query->fetchAll(PDO::FETCH_ASSOC); // Retourne tous les résultats sous forme de tableau associatif.
        }

    /**
     * Méthode pour récupérer tous les livres appartenant à un utilisateur spécifique.
     * 
     * @param int $ownerId L'ID de l'utilisateur propriétaire des livres.
     * @return array Liste des livres appartenant à l'utilisateur.
     */
        public function findBooksByUserId(int $ownerId) {
            $sql = "SELECT * FROM books WHERE owner_id = :ownerId";
            $params = [':ownerId' => $ownerId]; // Définit les paramètres pour la requête préparée.
            return $this->db->query($sql, $params)->fetchAll(); // Exécute la requête et retourne les résultats.
        }

    /**
     * Méthode pour récupérer les détails d'un livre à partir de son ID.
     * 
     * @param int $id L'ID du livre.
     * @return array|false Les détails du livre ou false si non trouvé.
     */
        public function getBookById($id) {
            $sql = "SELECT * FROM books WHERE id_book = :id"; 
            $params = [':id' => $id]; // Paramètre pour éviter les injections SQL.
            return $this->db->query($sql, $params)->fetch(); // Retourne les détails du livre en tableau associatif.
        }

    /**
     * Méthode pour ajouter un nouveau livre à la base de données.
     * 
     * @param string $title Le titre du livre.
     * @param string $author_name Le nom de l'auteur.
     * @param string $description La description du livre.
     * @param int $owner_id L'ID de l'utilisateur propriétaire du livre.
     * @param bool $is_available Disponibilité du livre (1 = disponible, 0 = non disponible).
     */
       // Méthode pour ajouter un livre, en utilisant l'objet Book
public function createBook(Book $book) {
    $db = DBManager::getInstance()->getPDO();

    // Requête SQL pour insérer un nouveau livre
    $sql = "INSERT INTO books (title, author_name, description, owner_id, is_available, image_path, creation_date, update_date)
            VALUES (:title, :author_name, :description, :owner_id, :is_available, :image_path, NOW(), NOW())";

    // Préparation de la requête SQL
    $stmt = $db->prepare($sql);

    // Exécution de la requête avec les données extraites de l'objet Book
    $stmt->execute([
        ':title' => $book->getTitle(),
        ':author_name' => $book->getAuthorName(),
        ':description' => $book->getDescription(),
        ':owner_id' => $book->getOwnerId(),
        ':is_available' => $book->getIsAvailable(),
        ':image_path' => $book->getImagePath(),
    ]);
}

    

    /**
     * Méthode pour mettre à jour les informations d'un livre existant.
     * 
     * @param int $id L'ID du livre à mettre à jour.
     * @param string $title Le nouveau titre du livre.
     * @param string $author Le nouveau nom de l'auteur.
     * @param string $description La nouvelle description du livre.
     * @param bool $isAvailable Nouvelle disponibilité du livre.
     * @param string|null $image_path Le chemin de la nouvelle image du livre (optionnel).
     */
        public function updateBook($id, $title, $author, $description, $isAvailable, $image_path = null) {
            // Préparer la requête de mise à jour
            $sql = "UPDATE books 
                    SET title = :title, author_name = :author, description = :description, 
                        is_available = :isAvailable, update_date = NOW()";

            // Si une image est fournie, ajouter le champ image_path à la requête
            if ($image_path !== null) {
                $sql .= ", image_path = :image_path";
            }

            // Ajouter la condition WHERE
            $sql .= " WHERE id_book = :id";

            // Définir les paramètres pour la requête préparée
            $params = [
                ':id' => $id,
                ':title' => $title,
                ':author' => $author,
                ':description' => $description,
                ':isAvailable' => $isAvailable
            ];

            // Ajouter le chemin de l'image si une nouvelle image est fournie
            if ($image_path !== null) {
                $params[':image_path'] = $image_path;
            }

            // Exécuter la requête de mise à jour
            $this->db->query($sql, $params);
        }

    /**
     * Méthode pour supprimer un livre de la base de données en fonction de son ID,
     * uniquement si l'utilisateur est le propriétaire du livre.
     * 
     * @param int $id L'ID du livre à supprimer.
     * @param int $userId L'ID de l'utilisateur qui tente de supprimer le livre.
     * @return bool Retourne true si la suppression a réussi, sinon false.
     */
        public function deleteBook($id, $userId) {
            // Vérifier si l'utilisateur est le propriétaire du livre
            $sql = "SELECT owner_id FROM books WHERE id_book = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            // Récupérer l'ID du propriétaire du livre
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Si le livre n'existe pas ou l'utilisateur n'est pas le propriétaire, retourner false
            if (!$result || $result['owner_id'] != $userId) {
                return false;
            }

            // Si l'utilisateur est le propriétaire, supprimer le livre
            $sql = "DELETE FROM books WHERE id_book = :id";
            $stmt = $this->db->prepare($sql);
            
            // Exécuter la requête de suppression
            return $stmt->execute([':id' => $id]);
        }

        public function deleteBookWithImage($id, $userId) {
            // Récupère les informations du livre
            $book = $this->getBookById($id);
        
            if ($book && $book['owner_id'] == $userId) {
                // Supprime l'image associée (si ce n'est pas l'image par défaut)
                $imagePath = $book['image_path'];
                if ($imagePath !== 'uploads/books/defaultBook.png' && file_exists($imagePath)) {
                    unlink($imagePath);
                }
        
                // Supprime le livre de la base
                return $this->deleteBook($id, $userId);
            }
        
            return false; // Retourne false si le livre n'existe pas ou si l'utilisateur n'est pas le propriétaire
        }
        
}

