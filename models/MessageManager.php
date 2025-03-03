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
    ) AS message_text
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
          LIMIT 1) DESC
";
        
        $params = ['userId' => $userId];
        $stmt = $this->db->query($sql, $params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
