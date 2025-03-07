<?php
/**
 * Classe abstraite représentant une entité.
 *
 * Cette classe fournit une méthode d'hydratation permettant de remplir les attributs
 * de l'entité à partir d'un tableau associatif. Elle gère également l'identifiant de l'entité.
 */
abstract class AbstractEntity
{
    // Par défaut, l'id vaut -1 pour indiquer que l'entité n'a pas encore été enregistrée.
    protected int $id = -1;

    /**
     * Constructeur de l'entité.
     *
     * Si un tableau associatif est fourni, l'entité est automatiquement hydratée
     * à l'aide des setters correspondants.
     *
     * @param array $data Tableau associatif contenant les données de l'entité.
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Hydrate l'entité avec les données fournies.
     *
     * Parcourt le tableau associatif et appelle les setters correspondants.
     * Les clés du tableau doivent correspondre aux noms des attributs de l'entité.
     * Les underscores dans les clés sont convertis en camelCase pour correspondre
     * aux noms des méthodes setter (exemple : "date_creation" devient "setDateCreation").
     *
     * @param array $data Tableau associatif contenant les données de l'entité.
     * @return void
     */
    protected function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            // Conversion de la clé en nom de méthode setter
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Définit l'identifiant de l'entité.
     *
     * @param int $id L'identifiant à attribuer.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Récupère l'identifiant de l'entité.
     *
     * @return int L'identifiant de l'entité.
     */
    public function getId(): int
    {
        return $this->id;
    }
}
