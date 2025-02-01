<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// class MessageController {

//     private BookManager $bookManager;
//     private UserManager $userManager;

//     public function __construct() {
//         // Crée une instance de MessageManager
//         $this->messageManager = new MessageManager();
//         $this->userManager = new UserManager();
//     }

//     public function showMessages() {
//         // Vérifie si l'utilisateur est connecté
//         Utils::checkIfUserIsConnected();
    
//         // Vérifie si l'ID de l'utilisateur est bien dans la session
//         if (!isset($_SESSION['user']['id'])) {
//             Utils::redirect('loginForm');
//             return; // Arrête l'exécution si l'utilisateur n'est pas connecté
//         }
    
//         // Récupérer l'ID de l'utilisateur connecté
//         $userId = $_SESSION['user']['id'];
        
//         // Récupère l'id du contact
//         $contactId = $this->userManager->getIdUser($userId);
//         // Récupère le pseudo du contact
//         $contactUsername = $this->userManager->getUsername($userId);
//         // Récupère l'image de profil du contact
//         $contactPicture = $this->userManager->getImagePathUser($userId);

//         // Récupérer les informations de l'utilisateur connecté (pseudo et image)
//         $user = $this->messageManager->getUserInfoById($userId);
    
//         // Récupérer les contacts de l'utilisateur
//         $contacts = $this->messageManager->getContacts($userId);
    
//         // Récupérer les derniers messages pour chaque contact
//         $lastMessages = $this->messageManager->getLastMessagesForUser($userId);
    
//         // Récupérer l'ID du contact via la query string (URL)
//         $contact_id = $_GET['contact_id'] ?? null;
    
//         // Récupérer les messages pour le contact sélectionné ou afficher tous les messages envoyés
//         $messagesData = [];
//         if ($contact_id) {
//             // Récupérer l'historique des messages entre l'utilisateur et ce contact
//             $messagesData = $this->messageManager->getMessagesBetweenUsers($userId, $contact_id);
    
//             // Ajouter les informations de l'expéditeur pour chaque message
//             foreach ($messagesData as $message) {
//                 $contact = $this->messageManager->getUserInfoById($message->getFromUser());
//                 $message->setContactUsername($contact['username']);
//                 $message->setContactImage($contact['image_path']);
//             }
//         } else {
//             // Si aucun contact n'est sélectionné, afficher un message pour choisir un contact
//             $messagesData = null;
//         }
    
//         // Passer les contacts, les messages, et l'utilisateur connecté à la vue
//         $view = new View('Messagerie');
//         $view->render('messaging', [
//             'contacts' => $contacts,
//             'messages' => $messagesData,
//             'toUser' => $contact_id,
//             'lastMessages' => $lastMessages,
//             'userPseudo' => $user['username'], // Le pseudo de l'utilisateur connecté
//             'userImage' => $user['image_path'] // L'image de l'utilisateur connecté
//         ]);
//     }
    

//     public function sendMessage() {
//         // Vérifie si l'utilisateur est connecté
//         Utils::checkIfUserIsConnected();

//         // Récupérer l'ID du contact et le message
//         $contact_id = $_GET['contact_id'] ?? null; // ID du contact
//         $message = $_POST['message'] ?? null;      // Message

//         // Vérification si les données sont bien récupérées
//         if ($contact_id && $message) {
//             // Sauvegarder le message dans la base de données
//             $this->messageManager->sendMessage($_SESSION['user']['id'], $contact_id, $message);
//             // Rediriger vers la page des messages
//             Utils::redirect('messaging', ['contact_id' => $contact_id]);
//         } else {
//             echo "Erreur : données manquantes.";
//         }
//     }
// }
// ?>


<?php
// class MessageController {

//     private MessageManager $messageManager;
//     private UserManager $userManager;

//     public function __construct() {
//         $this->messageManager = new MessageManager();
//         $this->userManager = new UserManager();
//     }

//     public function showMessages() {
//         // Vérifie si l'utilisateur est connecté
//         Utils::checkIfUserIsConnected();
        
//         $userId = $_SESSION['user']['id'];
        
//         // Récupérer les contacts et leurs derniers messages
//         $contacts = $this->messageManager->getContactsWithLastMessage($userId);

//         // Récupérer l'ID du contact sélectionné (si présent)
//         $contactId = $_GET['contact_id'] ?? null;
//         $messagesData = [];

//         // Gestion de la conversation active
//         $activeContact = null;
//         if ($contactId) {
//             // Récupérer les messages entre l'utilisateur et le contact
//             $messagesData = $this->messageManager->getMessagesBetweenUsers($userId, $contactId);

//             // Récupérer les infos du contact sélectionné
//             $activeContact = $this->userManager->getUserInfoById($contactId);
//         }

//         // Passer les données à la vue
//         $view = new View('Messagerie');
//         $view->render('messaging', [
//             'contacts' => $contacts,
//             'messages' => $messagesData,
//             'activeContact' => $activeContact,
//             'userPseudo' => $_SESSION['user']['username'],
//             'userImage' => $_SESSION['user']['image_path']
//         ]);
//     }

//     public function sendMessage() {
//         Utils::checkIfUserIsConnected();

//         $contactId = $_GET['contact_id'] ?? null;
//         $message = $_POST['message'] ?? null;

//         if ($contactId && $message) {
//             $this->messageManager->sendMessage($_SESSION['user']['id'], $contactId, $message);
//             Utils::redirect('messaging', ['contact_id' => $contactId]);
//         } else {
//             echo "Erreur : données manquantes.";
//         }
//     }
// }
?>
<?php

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
