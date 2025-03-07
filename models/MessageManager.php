<?php
/**
 * Cette classe gère toutes les opérations relatives aux messages dans la base de données.
 * Elle hérite d'AbstractEntityManager et utilise l'instance de DBManager pour exécuter les requêtes.
 */
class MessageManager extends AbstractEntityManager {

    /**
     * Envoie un message d'un utilisateur à un autre.
     *
     * @param int $fromUser L'ID de l'expéditeur.
     * @param int $toUser L'ID du destinataire.
     * @param string $messageText Le contenu du message.
     * @return void
     */
    public function sendMessage(int $fromUser, int $toUser, string $messageText): void {
        $sql = "
            INSERT INTO messages (from_user, to_user, message_text, created_at) 
            VALUES (:from_user, :to_user, :message_text, NOW())
        ";
        $params = [
            'from_user'    => $fromUser,
            'to_user'      => $toUser,
            'message_text' => $messageText,
        ];
        $this->db->query($sql, $params);
    }

    /**
     * Récupère l'historique des messages échangés entre deux utilisateurs.
     *
     * Les messages sont triés par date de création croissante.
     * Selon l'utilisateur connecté, les informations du contact sont adaptées.
     *
     * @param int $userId L'ID de l'utilisateur connecté.
     * @param int $contactId L'ID de l'autre utilisateur.
     * @return array Tableau d'objets Message.
     */
    public function getMessagesBetweenUsers($userId, $contactId) {
        $sql = "
            SELECT 
                m.id_message, 
                m.message_text, 
                m.created_at, 
                m.from_user, 
                m.to_user,
                u1.username AS sender_username,
                COALESCE(u1.image_path, 'uploads/users/defaultUser.png') AS sender_image,
                u2.username AS recipient_username,
                COALESCE(u2.image_path, 'uploads/users/defaultUser.png') AS recipient_image
            FROM messages m
            LEFT JOIN users u1 ON m.from_user = u1.id_user
            LEFT JOIN users u2 ON m.to_user = u2.id_user
            WHERE 
                (m.from_user = :userId AND m.to_user = :contactId) 
                OR 
                (m.from_user = :contactId AND m.to_user = :userId) 
            ORDER BY m.created_at ASC
        ";
        $params = [
            ':userId'    => $userId,
            ':contactId' => $contactId
        ];
        $stmt = $this->db->query($sql, $params);
        $messagesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Transformation des résultats en objets Message
        $messages = [];
        foreach ($messagesData as $data) {
            // Détermine si l'utilisateur connecté est l'expéditeur
            $isSender = $data['from_user'] == $userId;
            $messages[] = new Message([
                'from_user'       => $data['from_user'],
                'to_user'         => $data['to_user'],
                'message_text'    => $data['message_text'],
                'created_at'      => $data['created_at'],
                // Si l'utilisateur connecté est l'expéditeur, affiche les infos du destinataire,
                // sinon affiche les infos de l'expéditeur comme contact.
                'contact_username'=> $isSender ? $data['recipient_username'] : $data['sender_username'],
                'contact_image'   => $isSender ? $data['recipient_image'] : $data['sender_image'],
            ]);
        }
        return $messages;
    }

    /**
     * Compte le nombre de messages non lus destinés à un utilisateur.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @return int Le nombre de messages non lus.
     */
    public function countUnreadMessages($userId) {
        $sql = "
            SELECT COUNT(*) AS unread_count
            FROM messages
            WHERE to_user = :userId AND is_read = 0
        ";
        $params = [':userId' => $userId];
        $stmt = $this->db->query($sql, $params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['unread_count'] ?? 0;
    }

    /**
     * Marque comme lus tous les messages envoyés par un contact à un utilisateur.
     *
     * @param int $userId L'ID du destinataire.
     * @param int $contactId L'ID de l'expéditeur.
     * @return void
     */
    public function markMessagesAsRead(int $userId, int $contactId): void {
        $sql = "
            UPDATE messages
            SET is_read = 1
            WHERE to_user = :userId AND from_user = :contactId AND is_read = 0
        ";
        $params = [
            ':userId'    => $userId,
            ':contactId' => $contactId,
        ];
        $this->db->query($sql, $params);
    }

    /**
     * Récupère les informations d'un utilisateur à partir de son identifiant.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @return array|null Tableau associatif contenant 'username' et 'image_path' ou null si non trouvé.
     */
    public function getUserInfoById($userId) {
        $sql = "SELECT 
                    username, 
                    COALESCE(image_path, 'uploads/users/defaultUser.png') AS image_path 
                FROM users 
                WHERE id_user = :user_id";
        $params = ['user_id' => $userId];
        $query = $this->db->query($sql, $params);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            error_log("User ID $userId not found in database.");
        }
        return $result;
    }

    /**
     * Récupère la liste des contacts avec leur dernier message échangé.
     *
     * Cette méthode retourne les contacts avec lesquels l'utilisateur a déjà échangé des messages,
     * triés par date du dernier message décroissante.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @return array Tableau associatif contenant les informations des contacts et leur dernier message.
     */
    public function getContactsWithLastMessage($userId) {
        $sql = "SELECT 
                    users.id_user, 
                    users.username, 
                    COALESCE(users.image_path, 'uploads/users/defaultUser.png') AS image_path, 
                    (SELECT message_text FROM messages 
                        WHERE (from_user = users.id_user AND to_user = :userId) 
                           OR (from_user = :userId AND to_user = users.id_user) 
                        ORDER BY created_at DESC 
                        LIMIT 1
                    ) AS message_text,
                    (SELECT created_at FROM messages 
                        WHERE (from_user = users.id_user AND to_user = :userId) 
                           OR (from_user = :userId AND to_user = users.id_user) 
                        ORDER BY created_at DESC 
                        LIMIT 1
                    ) AS created_at
                FROM users
                WHERE users.id_user != :userId
                AND users.id_user IN (
                    SELECT DISTINCT CASE 
                        WHEN from_user = :userId THEN to_user 
                        ELSE from_user 
                    END 
                    FROM messages 
                    WHERE from_user = :userId OR to_user = :userId
                )
                ORDER BY (SELECT created_at FROM messages 
                          WHERE (from_user = users.id_user AND to_user = :userId) 
                             OR (from_user = :userId AND to_user = users.id_user) 
                          ORDER BY created_at DESC 
                          LIMIT 1) DESC";
        $params = ['userId' => $userId];
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
