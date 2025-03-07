<?php
/**
 * Cette classe est un singleton.
 * Pour récupérer une instance de cette classe, utilisez la méthode statique getInstance().
 */
class DBManager 
{
    // Instance statique unique (Singleton) qui maintient la connexion à la base de données
    private static $instance;

    // Instance de PDO utilisée pour interagir avec la base de données
    private $db;

    /**
     * Constructeur privé de la classe DBManager.
     *
     * Initialise la connexion à la base de données en utilisant PDO.
     * Le constructeur est privé afin d'empêcher la création d'instances multiples.
     *
     * @see DBManager::getInstance()
     */
    private function __construct() 
    {
        // Création de la connexion PDO avec les constantes définies (DB_HOST, DB_NAME, DB_USER, DB_PASS)
        $this->db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', 
            DB_USER, 
            DB_PASS
        );

        // Activation du mode d'erreur pour que PDO lance des exceptions en cas d'erreur SQL
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Définition du mode de récupération des résultats en tant que tableau associatif
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Récupère l'instance unique de DBManager.
     *
     * Cette méthode statique garantit qu'il n'existe qu'une seule instance de DBManager (Singleton).
     *
     * @return DBManager L'instance unique de DBManager.
     */
    public static function getInstance() : DBManager
    {
        // Crée l'instance si elle n'existe pas déjà
        if (!self::$instance) {
            self::$instance = new DBManager();
        }
        return self::$instance;
    }

    /**
     * Récupère l'objet PDO pour interagir avec la base de données.
     *
     * @return PDO L'instance PDO utilisée pour exécuter des requêtes SQL.
     */
    public function getPDO() : PDO
    {
        return $this->db;
    }

    /**
     * Exécute une requête SQL.
     *
     * Si des paramètres sont fournis, la requête est préparée et exécutée avec ces paramètres.
     * Sinon, une requête simple (non préparée) est exécutée.
     *
     * @param string $sql La requête SQL à exécuter.
     * @param array|null $params Les paramètres à binder dans la requête SQL (facultatif).
     * @return PDOStatement Le résultat de la requête sous forme de PDOStatement.
     */
    public function query(string $sql, ?array $params = null) : PDOStatement
    {
        // Si aucun paramètre n'est passé, exécute une requête simple
        if ($params == null) {
            $query = $this->db->query($sql);
        } else {
            // Prépare la requête SQL pour une exécution avec paramètres
            $query = $this->db->prepare($sql);

            // Vérifie si les paramètres sont positionnels (tableau indexé) ou nommés (tableau associatif)
            if (isset($params[0])) {
                // Exécute la requête avec des paramètres positionnels
                $query->execute(array_values($params));
            } else {
                // Exécute la requête avec des paramètres nommés
                $query->execute($params);
            }
        }
        return $query;
    }
}
