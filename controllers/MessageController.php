<?php

/**
 * Contrôleur de la messagerie.
 *
 * Ce contrôleur gère l'affichage de la messagerie (contacts, historique des messages)
 * et l'envoi de messages entre les utilisateurs.
 */
class MessageController {

    // Gestionnaire des messages et des utilisateurs
    private MessageManager $messageManager;
    private UserManager $userManager;

    /**
     * Constructeur : initialise les gestionnaires de messages et d'utilisateurs.
     */
    public function __construct() {
        $this->messageManager = new MessageManager();
        $this->userManager = new UserManager();
    }

    /**
     * Vérifie si l'utilisateur utilise un appareil mobile.
     *
     * @return bool Vrai si l'agent utilisateur correspond à un mobile, sinon faux.
     */
    private function isMobile(): bool {
        return preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod/i', $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Affiche la messagerie avec la liste des contacts et l'historique des messages.
     *
     * Si aucun contact n'est sélectionné, redirige (sur desktop) vers la dernière conversation.
     */
    public function showMessages() {
        // Vérifie que l'utilisateur est connecté
        Utils::checkIfUserIsConnected();

        $userId = $_SESSION['user']['id'];
        // Récupère la liste des contacts avec leur dernier message
        $contacts = $this->messageManager->getContactsWithLastMessage($userId);
        $contactId = $_GET['contact_id'] ?? null;
        $messagesData = [];
        $activeContact = null;

        // Si aucun contact n'est sélectionné et que des contacts existent, redirige sur desktop
        if (!$contactId && !empty($contacts)) {
            if (!$this->isMobile()) {  // uniquement pour les utilisateurs desktop
                $lastContactId = $contacts[0]['id_user'] ?? null;
                if ($lastContactId) {
                    Utils::redirect('messaging', ['contact_id' => $lastContactId]);
                    return;
                }
            }
        }

        // Si un contact est sélectionné
        if ($contactId) {
            // Récupère l'historique des messages entre l'utilisateur et le contact
            $messagesData = $this->messageManager->getMessagesBetweenUsers($userId, $contactId);
            // Marque les messages comme lus
            $this->messageManager->markMessagesAsRead($userId, $contactId);
            // Récupère les informations du contact actif
            $activeContact = $this->userManager->getUserInfoById($contactId);
        }

        // Affiche la vue de messagerie avec les données récupérées
        $view = new View('Messagerie');
        $view->render('messaging', [
            'contacts'      => $contacts,
            'messages'      => $messagesData,
            'activeContact' => $activeContact,
            'userPseudo'    => $_SESSION['user']['username'] ?? 'Utilisateur',
            'userImage'     => $_SESSION['user']['image_path'] ?? 'uploads/users/defaultUser.png',
        ]);
    }

    /**
     * Gère l'envoi d'un message vers un contact.
     *
     * Vérifie la présence des données nécessaires et redirige vers la conversation après envoi.
     */
    public function sendMessage() {
        // Vérifie que l'utilisateur est connecté
        Utils::checkIfUserIsConnected();

        $contactId = $_GET['contact_id'] ?? null;
        $message = $_POST['message'] ?? null;

        // Vérifie que le contact et le message sont définis
        if (!$contactId || !$message) {
            echo "Erreur : données manquantes.";
            return;
        }

        // Envoi du message via le gestionnaire de messages
        $this->messageManager->sendMessage($_SESSION['user']['id'], $contactId, $message);

        // Redirige vers la conversation du contact
        Utils::redirect('messaging', ['contact_id' => $contactId]);
    }
}
