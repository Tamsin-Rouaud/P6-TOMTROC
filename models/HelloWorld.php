<?php

/**
 * Entité représentant un message.
 * Avec les champs id et message.
 */
class HelloWorld extends AbstractEntity 
{
    private int $idMessage;
    private string $message;
        
    /**
     * Getter pour l'id du message.
     * @return int
     */
    public function getIdMessage(): int 
    {
        return $this->idMessage;
    }

    /**
     * Setter pour l'id du message.
     * @param int $idMessage
     * @return void
     */
    public function setIdMessage(int $idMessage): void 
    {
        $this->idMessage = $idMessage;
    }

    
    /**
     * Getter pour le message.
     * @return string
     */
    public function getMessage(): string 
    {
        return $this->message;
    }

    /**
     * Setter pour le contenu du message.
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void 
    {
        $this->message = $message;
    }
    

}
