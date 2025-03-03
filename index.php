<?php
// session_start();

ini_set('display_errors', 1);  // Affiche les erreurs
ini_set('display_startup_errors', 1);  // Affiche les erreurs lors du démarrage de PHP
error_reporting(E_ALL);  // Active l'affichage de toutes les erreurs


// Permet de servir directement les fichiers statiques (CSS, JS, images)
if (file_exists(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Charge les configurations et les classes nécessaires
require_once './config/config.php';  // Charger la configuration de l'application
require_once 'config/autoload.php';  // Charger l'autoloader pour inclure automatiquement les classes

$router = new Router();

// Définir les routes de l'application

$router->addRoute('lastBooks', 'BookController', 'showLastAddedBooks');


// La route 'availableBooks' appelle le contrôleur 'AvailableBooksCOntroller' et sa méthode 'showAvailableBooks'
$router->addRoute('availableBooks', 'BookController', 'showBooks');

// Cette route sert à afficher le détail d'un livre
$router->addRoute('bookDetails', 'BookController', 'showBookDetails');

// Cette route sert à afficher les livres d'un propriétaire unique
$router->addRoute('profileDetails', 'UserController', 'showProfileDetails');

// Route pour afficher les messages
$router->addRoute('messaging', 'MessageController', 'showMessages');

// Route pour envoyer un message
$router->addRoute('sendMessage', 'MessageController', 'sendMessage');



// Route pour la gestion des utilisateurs
// Cette route sera à afficher le formulaire de connexion et traite sa soumission
$router->addRoute('loginForm', 'UserController', 'showLoginForm');
// Cette route sert à afficher le formulaire d'inscription et à traiter sa soumission
$router->addRoute('showRegisterForm', 'UserController', 'showRegisterForm');

// Route pour la page "Mon compte"
$router->addRoute('myAccount', 'UserController', 'showMyAccount');

// Route pour soumettre les modifications des informations utilisateurs
$router->addRoute('updateUser', 'UserController', 'updateUser');

// Route pour gérer la mise à jour de la photo de profil
$router->addRoute('updateProfilePicture', 'UserController', 'updateProfilePicture');

// Route pour afficher le formulaire de modification de la photo de profil
$router->addRoute('addProfilePicture', 'UserController', 'showProfilePictureForm');


// Route pour ajouter un livre via la page mon compte
$router->addRoute('addBookForm', 'BookController', 'showAddBookForm');
$router->addRoute('addBook', 'BookController', 'addBook');

// // Route pour afficher le formulaire de modification d'un livre
// $router->addRoute('editBookForm', 'BookController', 'showEditBookForm');

// Route pour récupérer et gérer la soumission du formulaire de modification
$router->addRoute('editBook', 'BookController', 'editBook');

// Route pour gérer la soumission du formulaire de modification d'un livre
$router->addRoute('updateBook', 'BookController', 'updateBook');

// Ajout d'une nouvelle route pour la suppression d'un livre
$router->addRoute('deleteBook', 'BookController', 'deleteBook');


// Route pour afficher tous les livres
$router->addRoute('allBooks', 'BookController', 'showAllBooks');

// Route pour se déconnecter
$router->addRoute('logout', 'UserController', 'logout');

// La route 'search' appelle le contrôleur 'searchController' et sa méthode showSearch'
$router->addRoute('searchResults', 'BookController', 'searchResults');


// Définir une route par défaut (si aucune action n'est spécifiée dans l'URL)
// La route 'default' appelle le contrôleur 'HomeController' et sa méthode 'index'
$router->addRoute('default', 'HomeController', 'index');

// Récupérer l'action depuis l'URL ou définir 'default' si aucune action n'est spécifiée
$action = $_GET['action'] ?? 'default';  // Si l'action n'est pas présente dans l'URL, utiliser 'default'

// Si le paramètre `searchResults` est présent dans l'URL, on définit l'action à 'searchResults'
if (isset($_GET['searchResults'])) {
    $action = 'searchResults';  // On définit l'action comme 'searchResults' pour appeler le contrôleur 'SearchController'
}

// Essayer d'exécuter la route en appelant la méthode 'dispatch' du routeur avec l'action récupérée
try {
    $router->dispatch($action);  // Lancer la méthode de routage pour exécuter l'action correspondante
} catch (Exception $e) {
    // Si une exception est levée (par exemple, si l'action n'existe pas ou si un contrôleur/méthode est manquant),
    // afficher une erreur personnalisée à l'utilisateur.
    $errorController = new ErrorController();  // Créer une instance du contrôleur d'erreurs
    $errorController->showError($e->getMessage());  // Appeler la méthode 'showError' du contrôleur d'erreurs et afficher le message
}