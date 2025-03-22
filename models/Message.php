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
    // La date de création est maintenant stockée en tant qu'objet DateTime
    private ?DateTime $created_at = null;
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

    public function getFromUser(): ?int 
    {
        return $this->from_user;
    }

    public function getToUser(): ?int 
    {
        return $this->to_user;
    }

    public function getMessageText(): ?string 
    {
        return $this->message_text;
    }

    /**
     * Récupère la date de création du message.
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime 
    {
        return $this->created_at;
    }

    public function getContactUsername(): ?string 
    {
        return $this->contact_username;
    }

    public function getContactImage(): ?string 
    {
        return $this->contact_image;
    }

    public function getIsRead(): ?int
    {
        return $this->is_read;
    }

    // ----------------- Setters -----------------

    public function setFromUser(int $from_user): void 
    {
        $this->from_user = $from_user;
    }

    public function setToUser(int $to_user): void 
    {
        $this->to_user = $to_user;
    }

    public function setMessageText(string $message_text): void 
    {
        $this->message_text = $message_text;
    }

    /**
     * Définit la date de création du message.
     * Si la valeur passée est une chaîne, elle est convertie en objet DateTime.
     *
     * @param string|DateTime $created_at
     * @return void
     * @throws InvalidArgumentException Si le type est invalide.
     */
    public function setCreatedAt($created_at): void 
    {
        if (is_string($created_at)) {
            $this->created_at = new DateTime($created_at);
        } elseif ($created_at instanceof DateTime) {
            $this->created_at = $created_at;
        } else {
            throw new InvalidArgumentException("Invalid type for created_at");
        }
    }

    public function setContactUsername(string $username): void 
    {
        $this->contact_username = $username;
    }

    public function setContactImage(string $image): void 
    {
        $this->contact_image = $image;
    }

    public function isSentByUser(int $userId): bool 
    {
        return $this->from_user == $userId;
    }

    /**
     * Définit le statut de lecture du message.
     *
     * @param int $isRead
     * @return void
     */
    public function setIsRead(int $isRead): void
    {
        $this->is_read = $isRead;
    }
}
