<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


class MessageController {

    private MessageManager $messageManager;
    private UserManager $userManager;

    public function __construct() {
        $this->messageManager = new MessageManager();
        $this->userManager = new UserManager();
    }

    // Méthode de détection mobile
    private function isMobile(): bool {
        return preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod/i', $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Affiche la messagerie avec les contacts et messages associés.
     */
    public function showMessages() {
        Utils::checkIfUserIsConnected();
        
        $userId = $_SESSION['user']['id'];
        $contacts = $this->messageManager->getContactsWithLastMessage($userId);
        $contactId = $_GET['contact_id'] ?? null;
        $messagesData = [];
        $activeContact = null;
    
        // Si aucun contact n'est sélectionné, rediriger vers la dernière conversation (uniquement sur desktop)
        if (!$contactId && !empty($contacts)) {
            if (!$this->isMobile()) {  // uniquement en desktop
                $lastContactId = $contacts[0]['id_user'] ?? null;
                if ($lastContactId) {
                    Utils::redirect('messaging', ['contact_id' => $lastContactId]);
                    return;
                }
            }
        }
    
        if ($contactId) {
            // Récupérer l'historique des messages entre l'utilisateur et le contact
            $messagesData = $this->messageManager->getMessagesBetweenUsers($userId, $contactId);
    
            // Marquer les messages comme lus
            $this->messageManager->markMessagesAsRead($userId, $contactId);
    
            // Récupérer les infos du contact sélectionné
            $activeContact = $this->userManager->getUserInfoById($contactId);
        }
    
        $view = new View('Messagerie');
        $view->render('messaging', [
            'contacts' => $contacts,
            'messages' => $messagesData,
            'activeContact' => $activeContact,
            'userPseudo' => $_SESSION['user']['username'] ?? 'Utilisateur',
            'userImage' => $_SESSION['user']['image_path'] ?? 'uploads/users/defaultUser.png',
        ]);
    }
    
    /**
     * Gère l'envoi d'un message.
     */
    public function sendMessage() {
        Utils::checkIfUserIsConnected();
        $contactId = $_GET['contact_id'] ?? null;
        $message = $_POST['message'] ?? null;
        if (!$contactId || !$message) {
            echo "Erreur : données manquantes.";
            return;
        }
        $this->messageManager->sendMessage($_SESSION['user']['id'], $contactId, $message);
        Utils::redirect('messaging', ['contact_id' => $contactId]);
    }
}
