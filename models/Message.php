<?php

class Message extends AbstractEntity
{
    private $from_user;
    private $to_user;
    private $message_text;
    private $created_at;
    private $contact_username;
    private $contact_image;

    // Le constructeur appelle le constructeur parent pour gérer l'hydratation
    public function __construct(array $data = []) 
    {
        parent::__construct($data); // Appel du constructeur parent pour hydrater l'entité
    }

    // Getters
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

    public function getCreatedAt(): ?string 
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

    // Setters
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

    public function setCreatedAt(string $created_at): void 
    {
        $this->created_at = $created_at;
    }

    public function setContactUsername(string $username): void 
    {
        $this->contact_username = $username;
    }

    public function setContactImage(string $image): void 
    {
        $this->contact_image = $image;
    }
}
