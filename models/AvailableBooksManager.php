<?php

class AvailableBooksManager extends AbstractEntityManager {

public function getAvailableBooksMessage() :string {
        $sql = "SELECT author_name FROM books";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['author_name'] ?? 'Hello me (par défaut)'; // Sélectionner le nom de champ de la BDD
    }
  
}