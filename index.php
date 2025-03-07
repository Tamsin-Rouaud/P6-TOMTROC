<?php
// Activation du mode d'affichage des erreurs pour faciliter le débogage (à désactiver en production)
ini_set('display_errors', 1);               // Affiche les erreurs
ini_set('display_startup_errors', 1);       // Affiche les erreurs lors du démarrage de PHP
error_reporting(E_ALL);                     // Active l'affichage de toutes les erreurs

// Permet de servir directement les fichiers statiques (CSS, JS, images)
// Si le chemin demandé correspond à un fichier existant, PHP le sert directement
if (file_exists(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Chargement des configurations et des classes nécessaires
require_once './config/config.php';   // Charger la configuration de l'application
require_once 'config/autoload.php';     // Charger l'autoloader pour inclure automatiquement les classes

// Instanciation du routeur
$router = new Router();

// Définition des routes de l'application

// Routes pour les livres
$router->addRoute('lastBooks', 'BookController', 'showLastAddedBooks');
$router->addRoute('availableBooks', 'BookController', 'showBooks');
$router->addRoute('bookDetails', 'BookController', 'showBookDetails');
$router->addRoute('allBooks', 'BookController', 'showAllBooks');

// Routes pour la messagerie
$router->addRoute('messaging', 'MessageController', 'showMessages');
$router->addRoute('sendMessage', 'MessageController', 'sendMessage');

// Routes pour la gestion des utilisateurs
$router->addRoute('loginForm', 'UserController', 'showLoginForm');
$router->addRoute('showRegisterForm', 'UserController', 'showRegisterForm');
$router->addRoute('myAccount', 'UserController', 'showMyAccount');
$router->addRoute('updateUser', 'UserController', 'updateUser');
$router->addRoute('logout', 'UserController', 'logout');

// Routes pour la gestion du profil
$router->addRoute('updateProfilePicture', 'UserController', 'updateProfilePicture');
$router->addRoute('addProfilePicture', 'UserController', 'showProfilePictureForm');
$router->addRoute('profileDetails', 'UserController', 'showProfileDetails');

// Routes pour la gestion des livres (ajout et modification)
$router->addRoute('addBookForm', 'BookController', 'showAddBookForm');
$router->addRoute('addBook', 'BookController', 'addBook');
$router->addRoute('editBook', 'BookController', 'editBook');
$router->addRoute('updateBook', 'BookController', 'updateBook');
$router->addRoute('deleteBook', 'BookController', 'deleteBook');

// Route pour la recherche
$router->addRoute('searchResults', 'BookController', 'searchResults');

// Route par défaut (affichée si aucune action n'est spécifiée)
$router->addRoute('default', 'HomeController', 'index');

// Récupération de l'action depuis l'URL (si non présente, on utilise 'default')
$action = $_GET['action'] ?? 'default';

// Si le paramètre 'searchResults' est présent dans l'URL, forcer l'action à 'searchResults'
if (isset($_GET['searchResults'])) {
    $action = 'searchResults';
}

// Essayer d'exécuter la route correspondante via le routeur
try {
    $router->dispatch($action);
} catch (Exception $e) {
    // En cas d'erreur (action non trouvée, contrôleur ou méthode manquante), utiliser le contrôleur d'erreurs pour afficher un message
    $errorController = new ErrorController();
    $errorController->showError($e->getMessage());
}
