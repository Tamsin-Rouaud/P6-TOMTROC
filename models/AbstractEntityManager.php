<?php
/**
 * Classe abstraite représentant un manager d'entités.
 *
 * Cette classe permet de centraliser l'accès à la base de données en récupérant
 * automatiquement l'instance unique du gestionnaire de base de données (DBManager).
 */
abstract class AbstractEntityManager {

    // Instance du gestionnaire de base de données
    protected $db;

    /**
     * Constructeur de la classe.
     *
     * Récupère automatiquement l'instance unique de DBManager via le pattern Singleton.
     */
    public function __construct() {
        $this->db = DBManager::getInstance();
    }
}
