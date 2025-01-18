<?php


    class User extends AbstractEntity 
    {
        private int $idUser;
        private string $username;
        private string $email;
        private string $password;
        private string $imagePathUser;
        private ?DateTime $dateCreationUser = null;

        /**
         * Getter pour l'id de l'utilisateur
         * @return int
         */
        public function getIdUser(): int
        {
            return $this->idUser;
        }

        /**
         * Setter pour l'id de l'utilisateur
         * @param string $idUser
         */
        public function setIdUser(int $idUser): void
        {
            $this->idUser = $idUser;
        }

        
        /**
         * Getter pour le pseudo
         * @return string $username
         */
        public function getUsername(): string
        {
            return $this->username;
        }

        /**
         * Setter pour le pseudo
         * @param string $username
         */
        public function setUsername(string $username): void
        {
            $this->username = $username;
        }


        /**
         * Getter pour l'email
         * @return string $email
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * Setter pour l'email
         * @param string email
         */
        public function setEmail(string $email): void
        {
            $this->email = $email;
        }


        /**
         * Getter pour le mot de passe
         * @return string $password
         */
        public function getPassword(): string
        {
            return $this->password;
        }

        /**
         * Setter pour le mot de passe
         * @param string $password
         */
        public function setPassword(string $password): void
        {
            $this->password = $password;
        }


        /**
         * Getter pour le lien de l'image de profil
         * @return string $imagePathUser
         */
        public function getImagePathUser():string
        {
            return $this->imagePathUser;
        }

        /**
         * Setter pour le lien de l'image de profil
         * @param string $imagePathUser
         */
        public function setImagePathUser(string $imagePathUser):void
        {
            $this->imagePathUser = $imagePathUser;
        }


        public function setDateCreationUser(?string $date): void {
            if (is_string($date)) {
                $this->dateCreationUser = new DateTime($date);
            } elseif ($date instanceof DateTime || $date === null) {
                $this->dateCreationUser = $date;
            } else {
                throw new InvalidArgumentException('Invalid type for date creation');
            }
        }
        
    
        public function getDateCreationUser(): ?DateTime {
            return $this->dateCreationUser;
        }
    }
