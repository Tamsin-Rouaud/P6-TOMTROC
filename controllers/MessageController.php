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
    
        // Si aucun contact n'est sélectionné, rediriger vers la dernière conversation
        if (!$contactId && !empty($contacts)) {
            $lastContactId = $contacts[0]['id_user'] ?? null;
            if ($lastContactId) {
                Utils::redirect('messaging', ['contact_id' => $lastContactId]);
                return;
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
        // Vérifie si l'utilisateur est connecté
        Utils::checkIfUserIsConnected();

        // Récupérer les données du formulaire
        $contactId = $_GET['contact_id'] ?? null;
        $message = $_POST['message'] ?? null;

        // Vérifie si les données nécessaires sont présentes
        if (!$contactId || !$message) {
            echo "Erreur : données manquantes.";
            return;
        }

        // Sauvegarder le message dans la base de données
        $this->messageManager->sendMessage($_SESSION['user']['id'], $contactId, $message);

        // Rediriger vers la messagerie avec le contact sélectionné
        Utils::redirect('messaging', ['contact_id' => $contactId]);
    }
}
