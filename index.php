<?php

ini_set('display_errors', 1);  // Affiche les erreurs
ini_set('display_startup_errors', 1);  // Affiche les erreurs lors du démarrage de PHP
error_reporting(E_ALL);  // Active l'affichage de toutes les erreurs

// Charger les configurations et les classes nécessaires
require_once './config/config.php';  // Charger la configuration de l'application
require_once 'config/autoload.php';  // Charger l'autoloader pour inclure automatiquement les classes

$router = new Router();

// Définir les routes de l'application

// La route 'availableBooks' appelle le contrôleur 'AvailableBooksCOntroller' et sa méthode 'showAvailableBooks'
$router->addRoute('availableBooks', 'AvailableBooksController', 'showAvailableBooks');

// Route pour la gestion des utilisateurs
// Cette route sera à afficher le formulaire de connexion et traite sa soumission
$router->addRoute('loginForm', 'UserController', 'showLoginForm');
// Cette route sert à afficher le formulaire d'inscription et à traiter sa soumission
$router->addRoute('register', 'UserController', 'showRegisterForm');



// La route 'registerForm' appelle le contrôleur 'userController' et sa méthode 'showLoginForm'
$router->addRoute('registerForm', 'UserController', 'showRegisterForm');
// La route 'search' appelle le contrôleur 'searchController' et sa méthode showSearch'
$router->addRoute('search', 'searchController', 'showSearch');
// Définir une route par défaut (si aucune action n'est spécifiée dans l'URL)
// La route 'default' appelle le contrôleur 'HomeController' et sa méthode 'index'
$router->addRoute('default', 'HomeController', 'index');

// Récupérer l'action depuis l'URL ou définir 'default' si aucune action n'est spécifiée
$action = $_GET['action'] ?? 'default';  // Si l'action n'est pas présente dans l'URL, utiliser 'default'

// Si le paramètre `search` est présent dans l'URL, on définit l'action à 'search'
if (isset($_GET['search'])) {
    $action = 'search';  // On définit l'action comme 'search' pour appeler le contrôleur 'SearchController'
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
