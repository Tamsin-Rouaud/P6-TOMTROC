<?php

class SearchManager extends AbstractEntityManager {
    public function searchBooks($searchTerm) {
        // Requête SQL pour rechercher des livres
        $sql = "SELECT * FROM books WHERE title LIKE :searchTerm";
        $stmt = $this->db->prepare($sql, ['searchTerm' => "%$searchTerm%"]);
        return $stmt->fetchAll();
    }
}
