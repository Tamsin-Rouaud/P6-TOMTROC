<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class MessageController {

    protected $messageManager;

    public function __construct() {
        // Crée une instance de MessageManager
        $this->messageManager = new MessageManager();
    }

    public function showMessages() {
        // Vérifie si l'utilisateur est connecté
        Utils::checkIfUserIsConnected();
    
        // Vérifie si l'ID de l'utilisateur est bien dans la session
        if (!isset($_SESSION['user']['id'])) {
            Utils::redirect('loginForm');
            return; // Arrête l'exécution si l'utilisateur n'est pas connecté
        }
    
        // Récupérer l'ID de l'utilisateur connecté
        $userId = $_SESSION['user']['id'];
    
        // Récupérer les informations de l'utilisateur connecté (pseudo et image)
        $user = $this->messageManager->getUserInfoById($userId);
    
        // Récupérer les contacts de l'utilisateur
        $contacts = $this->messageManager->getContacts($userId);
    
        // Récupérer les derniers messages pour chaque contact
        $lastMessages = $this->messageManager->getLastMessagesForUser($userId);
    
        // Récupérer l'ID du contact via la query string (URL)
        $contact_id = $_GET['contact_id'] ?? null;
    
        // Récupérer les messages pour le contact sélectionné ou afficher tous les messages envoyés
        $messagesData = [];
        if ($contact_id) {
            // Récupérer l'historique des messages entre l'utilisateur et ce contact
            $messagesData = $this->messageManager->getMessagesBetweenUsers($userId, $contact_id);
    
            // Ajouter les informations de l'expéditeur pour chaque message
            foreach ($messagesData as $message) {
                $contact = $this->messageManager->getUserInfoById($message->getFromUser());
                $message->setContactUsername($contact['username']);
                $message->setContactImage($contact['image_path']);
            }
        } else {
            // Si aucun contact n'est sélectionné, afficher un message pour choisir un contact
            $messagesData = null;
        }
    
        // Passer les contacts, les messages, et l'utilisateur connecté à la vue
        $view = new View('Messagerie');
        $view->render('messaging', [
            'contacts' => $contacts,
            'messages' => $messagesData,
            'toUser' => $contact_id,
            'lastMessages' => $lastMessages,
            'userPseudo' => $user['username'], // Le pseudo de l'utilisateur connecté
            'userImage' => $user['image_path'] // L'image de l'utilisateur connecté
        ]);
    }
    

    public function sendMessage() {
        // Vérifie si l'utilisateur est connecté
        Utils::checkIfUserIsConnected();

        // Récupérer l'ID du contact et le message
        $contact_id = $_GET['contact_id'] ?? null; // ID du contact
        $message = $_POST['message'] ?? null;      // Message

        // Vérification si les données sont bien récupérées
        if ($contact_id && $message) {
            // Sauvegarder le message dans la base de données
            $this->messageManager->sendMessage($_SESSION['user']['id'], $contact_id, $message);
            // Rediriger vers la page des messages
            Utils::redirect('messaging', ['contact_id' => $contact_id]);
        } else {
            echo "Erreur : données manquantes.";
        }
    }
}
?>
