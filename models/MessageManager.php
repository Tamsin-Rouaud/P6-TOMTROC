<?php

class MessageManager extends AbstractEntityManager {

    public function sendMessage(int $fromUser, int $toUser, string $messageText): void {
        $sql = "
            INSERT INTO messages (from_user, to_user, message_text, created_at) 
            VALUES (:from_user, :to_user, :message_text, NOW())
        ";
        $params = [
            'from_user' => $fromUser,
            'to_user' => $toUser,
            'message_text' => $messageText,
        ];

        $this->db->query($sql, $params);
    }

    // public function getConversationHistory($userId) {
    //     $sql = "
    //         SELECT 
    //             m.id_message, 
    //             m.message_text, 
    //             m.created_at, 
    //             m.from_user, 
    //             m.to_user, 
    //             u1.username AS sender_username, 
    //             u1.image_path AS sender_image,
    //             u2.username AS recipient_username, 
    //             u2.image_path AS recipient_image
    //         FROM 
    //             messages m
    //         LEFT JOIN 
    //             users u1 ON m.from_user = u1.id_user
    //         LEFT JOIN 
    //             users u2 ON m.to_user = u2.id_user
    //         WHERE 
    //             m.from_user = :currentUserId OR m.to_user = :currentUserId
    //         ORDER BY 
    //             m.created_at ASC;
    //     ";
    
    //     // Paramètres de la requête
    //     $params = [':currentUserId' => $userId];
    
    //     // Exécution de la requête
    //     $stmt = $this->db->query($sql, $params);
        
    //     // Récupération des résultats
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    
    public function getConversationHistory($userId) {
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
            FROM 
                messages m
            LEFT JOIN 
                users u1 ON m.from_user = u1.id_user
            LEFT JOIN 
                users u2 ON m.to_user = u2.id_user
            WHERE 
                m.from_user = :currentUserId OR m.to_user = :currentUserId
            ORDER BY 
                m.created_at ASC;
        ";
        $params = [':currentUserId' => $userId];
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    // public function getMessagesBetweenUsers($userId, $contactId) {
    //     // Requête SQL pour récupérer les messages entre les deux utilisateurs
    //     $sql = "SELECT * FROM messages 
    //             WHERE (from_user = :userId AND to_user = :contactId) 
    //             OR (from_user = :contactId AND to_user = :userId) 
    //             ORDER BY created_at ASC";
        
    //     // Préparer les paramètres pour la requête
    //     $params = [
    //         ':userId' => $userId,
    //         ':contactId' => $contactId
    //     ];
    
    //     // Utiliser la méthode query pour exécuter la requête avec les paramètres
    //     $stmt = $this->db->query($sql, $params);
    
    //     // Récupérer les messages sous forme de tableau associatif
    //     $messagesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //     // Créer les objets Message en passant les données à chaque instance
    //     $messages = [];
    //     foreach ($messagesData as $data) {
    //         // Créer un nouvel objet Message avec les données
    //         $message = new Message($data);
    //         $messages[] = $message;
    //     }
    
    //     return $messages;
    // }

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
            FROM 
                messages m
            LEFT JOIN 
                users u1 ON m.from_user = u1.id_user
            LEFT JOIN 
                users u2 ON m.to_user = u2.id_user
            WHERE 
                (m.from_user = :userId AND m.to_user = :contactId) 
                OR 
                (m.from_user = :contactId AND m.to_user = :userId) 
            ORDER BY 
                m.created_at ASC";
    
        $params = [
            ':userId' => $userId,
            ':contactId' => $contactId
        ];
    
        $stmt = $this->db->query($sql, $params);
        $messagesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Transformez les résultats en objets Message
        $messages = [];
        foreach ($messagesData as $data) {
            $isSender = $data['from_user'] == $userId;
    
            $messages[] = new Message([
                'from_user' => $data['from_user'],
                'to_user' => $data['to_user'],
                'message_text' => $data['message_text'],
                'created_at' => $data['created_at'],
                'contact_username' => $isSender ? $data['recipient_username'] : $data['sender_username'],
                'contact_image' => $isSender ? $data['recipient_image'] : $data['sender_image'],
            ]);
        }
    
        return $messages;
    }
    
    public function countUnreadMessages($userId) {
        $sql = "
            SELECT COUNT(*) AS unread_count
            FROM messages
            WHERE to_user = :userId AND is_read = 0
        ";
        $params = [
            ':userId' => $userId,
        ];
        $stmt = $this->db->query($sql, $params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['unread_count'] ?? 0;
    }
    
    public function markMessagesAsRead(int $userId, int $contactId): void {
        $sql = "
            UPDATE messages
            SET is_read = 1
            WHERE to_user = :userId AND from_user = :contactId AND is_read = 0
        ";
        $params = [
            ':userId' => $userId,
            ':contactId' => $contactId,
        ];
        $this->db->query($sql, $params);
    }
    

    
    public function getLastMessagesForUser($userId) {
        $sql = "SELECT 
                    m.message_text, 
                    m.created_at, 
                    CASE 
                        WHEN m.from_user = :userId THEN m.to_user 
                        ELSE m.from_user 
                    END AS contact_id,
                    u.username,
                    COALESCE(u.image_path, 'uploads/users/defaultUser.png') AS image_path
                FROM messages m
                JOIN users u ON u.id_user = CASE 
                                               WHEN m.from_user = :userId THEN m.to_user 
                                               ELSE m.from_user 
                                            END
                WHERE m.from_user = :userId OR m.to_user = :userId
                GROUP BY contact_id
                ORDER BY m.created_at DESC";
    
        $params = [':userId' => $userId];
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
// Lister les discussions existantes
public function getContacts(int $userId): array {
    $sql = "
        SELECT DISTINCT 
            CASE
                WHEN m.from_user = :user_id THEN m.to_user
                ELSE m.from_user
            END AS contact_id,
            u.username,
            u.image_path,
            lm.message_text,  -- Dernier message
            lm.created_at AS last_message_date,  -- Date du dernier message
            lm.from_user AS last_sender_id  -- ID de l'expéditeur du dernier message
        FROM messages m
        INNER JOIN users u ON u.id_user = CASE
            WHEN m.from_user = :user_id THEN m.to_user
            ELSE m.from_user
        END
        LEFT JOIN (
            SELECT 
                m1.from_user,
                m1.to_user,
                m1.message_text,
                m1.created_at,
                m1.from_user AS last_sender_id
            FROM messages m1
            WHERE m1.from_user = :user_id OR m1.to_user = :user_id
            ORDER BY m1.created_at DESC
            LIMIT 1
        ) AS lm ON lm.from_user = m.from_user AND lm.to_user = m.to_user
        WHERE m.from_user = :user_id OR m.to_user = :user_id
    ";

    $params = [
        'user_id' => $userId,
    ];

    $query = $this->db->query($sql, $params);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}





     // Requête pour récupérer le pseudo et l'image de profil d'un utilisateur par ID
    // public function getUserInfoById($userId) {
       
    //     $sql = "SELECT username, image_path FROM users WHERE id_user = :user_id";
    //     $params = ['user_id' => $userId];
    //     $stmt = $this->db->query($sql, $params);
    //     // $stmt->execute(['user_id' => $userId]);
        
    //     // Retourne le résultat sous forme de tableau associatif
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }


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
    
    // Afficher historique messages

    public function getAllSentMessagesByUser($userId) {
        $sql = "SELECT 
                    m.id_message, m.message_text, m.created_at, m.from_user, m.to_user,
                    u.username AS recipient_name, u.image_path AS recipient_image
                FROM 
                    messages m
                JOIN 
                    users u ON u.id_user = m.to_user
                WHERE 
                    m.from_user = ?
                ORDER BY 
                    m.created_at DESC";
    
        $result = $this->db->query($sql, [$userId]);
        $messages = [];
    
        foreach ($result as $row) {
            $messages[] = new Message(
                $row['id_message'],
                $row['message_text'],
                $row['created_at'],
                $row['from_user'],
                $row['to_user'],
                $row['recipient_name'],
                $row['recipient_image']
            );
        }
    
        return $messages;
    }
    
    public function getContactsWithLastMessage($userId) {
        $sql = "SELECT 
                    users.id_user, 
                    users.username, 
                    COALESCE(users.image_path, 'uploads/users/defaultUser.png') AS image_path, 
                    messages.message_text, 
                    messages.created_at
                FROM users
                JOIN messages ON (messages.from_user = users.id_user OR messages.to_user = users.id_user)
                WHERE users.id_user != :userId
                AND (messages.from_user = :userId OR messages.to_user = :userId)
                GROUP BY users.id_user
                ORDER BY messages.created_at DESC";
        $params = ['userId' => $userId];
        $stmt = $this->db->query($sql, $params);
    
        // Débogage
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($results);
        // exit;
    
        return $results;
    }
    


}
