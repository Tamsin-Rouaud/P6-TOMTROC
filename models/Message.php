<?php
/**
 * Entité représentant un message échangé entre utilisateurs.
 *
 * Cette classe hérite d'AbstractEntity et gère les propriétés d'un message,
 * telles que l'expéditeur, le destinataire, le texte du message, la date de création,
 * ainsi que des informations supplémentaires sur le contact.
 */
class Message extends AbstractEntity
{
    // Propriétés privées du message
    private $from_user;         // Identifiant de l'expéditeur
    private $to_user;           // Identifiant du destinataire
    private $message_text;      // Contenu du message
    private $created_at;        // Date de création du message (souvent en format string ou DateTime)
    private $contact_username;  // Nom du contact (pour affichage dans la messagerie)
    private $contact_image;     // Chemin vers l'image du contact
    private $is_read;           // Statut de lecture (0 = non lu, 1 = lu)

    /**
     * Constructeur de l'entité Message.
     *
     * Appelle le constructeur parent pour permettre l'hydratation automatique
     * à partir d'un tableau associatif.
     *
     * @param array $data Tableau associatif contenant les données du message.
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    // ----------------- Getters -----------------

    /**
     * Récupère l'identifiant de l'expéditeur.
     *
     * @return int|null
     */
    public function getFromUser(): ?int 
    {
        return $this->from_user;
    }

    /**
     * Récupère l'identifiant du destinataire.
     *
     * @return int|null
     */
    public function getToUser(): ?int 
    {
        return $this->to_user;
    }

    /**
     * Récupère le texte du message.
     *
     * @return string|null
     */
    public function getMessageText(): ?string 
    {
        return $this->message_text;
    }

    /**
     * Récupère la date de création du message.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string 
    {
        return $this->created_at;
    }

    /**
     * Récupère le nom du contact associé au message.
     *
     * @return string|null
     */
    public function getContactUsername(): ?string 
    {
        return $this->contact_username;
    }

    /**
     * Récupère le chemin vers l'image du contact.
     *
     * @return string|null
     */
    public function getContactImage(): ?string 
    {
        return $this->contact_image;
    }

    /**
     * Récupère le statut de lecture du message.
     *
     * @return int|null
     */
    public function getIsRead(): ?int
    {
        return $this->is_read;
    }

    // ----------------- Setters -----------------

    /**
     * Définit l'expéditeur du message.
     *
     * @param int $from_user
     * @return void
     */
    public function setFromUser(int $from_user): void 
    {
        $this->from_user = $from_user;
    }

    /**
     * Définit le destinataire du message.
     *
     * @param int $to_user
     * @return void
     */
    public function setToUser(int $to_user): void 
    {
        $this->to_user = $to_user;
    }

    /**
     * Définit le contenu du message.
     *
     * @param string $message_text
     * @return void
     */
    public function setMessageText(string $message_text): void 
    {
        $this->message_text = $message_text;
    }

    /**
     * Définit la date de création du message.
     *
     * @param string $created_at
     * @return void
     */
    public function setCreatedAt(string $created_at): void 
    {
        $this->created_at = $created_at;
    }

    /**
     * Définit le nom du contact associé.
     *
     * @param string $username
     * @return void
     */
    public function setContactUsername(string $username): void 
    {
        $this->contact_username = $username;
    }

    /**
     * Définit le chemin vers l'image du contact.
     *
     * @param string $image
     * @return void
     */
    public function setContactImage(string $image): void 
    {
        $this->contact_image = $image;
    }

    /**
     * Indique si le message a été envoyé par un utilisateur donné.
     *
     * @param int $userId L'identifiant de l'utilisateur à comparer.
     * @return bool Vrai si l'expéditeur est égal à l'identifiant fourni, sinon faux.
     */
    public function isSentByUser(int $userId): bool 
    {
        return $this->from_user == $userId;
    }
    
    /**
     * Définit le statut de lecture du message.
     *
     * Remarque : Cette méthode retourne la valeur assignée, ce qui est inhabituel pour un setter.
     * Habituellement, un setter ne retourne rien (void).
     *
      * @param int $isRead
      * @return int La valeur du statut de lecture assignée.
      */
    // public function setIsRead(int $isRead): int
    // {
    //     return $this->is_read = $isRead;
    // }
    public function setIsRead(int $isRead): void
{
    $this->is_read = $isRead;
}

}
