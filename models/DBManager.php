<?php

/**
 * Cette classe est un singleton. 
 * Pour récupérer une instance de cette classe, il faut utiliser la méthode getInstance().
 */
class DBManager 
{
    // Instance statique pour maintenir l'unicité de la connexion (patron Singleton)
    private static $instance;
    
    // Instance de PDO qui gère la connexion à la base de données
    private $db;

    /**
     * Constructeur privé de la classe DBManager.
     * Initialise la connexion à la base de données.
     * Ce constructeur est privé pour éviter la création d'instances multiples.
     * @see DBManager::getInstance()
     */
    private function __construct() 
    {
        // Création de la connexion PDO avec les informations de la base de données
        // Utilisation des constantes définies (DB_HOST, DB_NAME, DB_USER, DB_PASS) pour se connecter à la base de données
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        
        // Activation du mode d'erreur pour afficher les exceptions en cas d'erreur dans les requêtes SQL
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Définition du mode de récupération des résultats : ici, sous forme de tableau associatif
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Méthode statique qui permet de récupérer l'instance de la classe DBManager.
     * Cette méthode garantit qu'il n'y aura qu'une seule instance de la classe (Singleton).
     * @return DBManager : l'instance unique de DBManager.
     */
    public static function getInstance() : DBManager
    {
        // Si l'instance n'existe pas encore, on la crée.
        if (!self::$instance) {
            self::$instance = new DBManager();
        }
        // Retourne l'instance unique.
        return self::$instance;
    }

    /**
     * Méthode qui permet de récupérer l'objet PDO pour interagir avec la base de données.
     * @return PDO : l'objet PDO utilisé pour les requêtes SQL.
     */
    public function getPDO() : PDO
    {
        return $this->db;  // Retourne l'instance de PDO.
    }

    /**
     * Méthode qui permet d'exécuter une requête SQL.
     * Si des paramètres sont passés, on utilise une requête préparée avec des paramètres bindés.
     * @param string $sql : la requête SQL à exécuter.
     * @param array|null $params : les paramètres pour la requête SQL (par défaut null).
     * @return PDOStatement : le résultat de la requête SQL sous forme de PDOStatement.
     */
    public function query(string $sql, ?array $params = null) : PDOStatement
{
    // Si aucun paramètre n'est passé, on exécute une requête simple (non préparée)
    if ($params == null) {
        $query = $this->db->query($sql);
    } else {
        // Si des paramètres sont passés, on prépare la requête et on exécute avec les paramètres
        $query = $this->db->prepare($sql);
        
        // Vérifier si des paramètres nommés sont présents
        if ($params && isset($params[0])) {
            // Si le premier élément du tableau est une valeur (paramètres positionnels)
            $query->execute(array_values($params)); // Exécute avec des paramètres positionnels
        } else {
            // Si c'est un tableau associatif avec des paramètres nommés
            $query->execute($params); // Exécute avec des paramètres nommés
        }
    }
    // Retourne le résultat de la requête
    return $query;
}

}