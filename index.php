<?php

ini_set('display_errors', 1);  // Affiche les erreurs
ini_set('display_startup_errors', 1);  // Affiche les erreurs lors du démarrage de PHP
error_reporting(E_ALL);  // Active l'affichage de toutes les erreurs

// Charger les configurations et les classes nécessaires
require_once './config/config.php';  // Charger la configuration de l'application
require_once 'config/autoload.php';  // Charger l'autoloader pour inclure automatiquement les classes

$router = new Router();

// Définir les routes de l'application

// Définir une route par défaut (si aucune action n'est spécifiée dans l'URL)
// La route 'default' appelle le contrôleur 'HomeController' et sa méthode 'index'
$router->addRoute('default', 'HomeController', 'index');

// Récupérer l'action depuis l'URL ou définir 'default' si aucune action n'est spécifiée
// Si l'URL contient ?action=<action>, on récupère la valeur de 'action', sinon on utilise 'default'
$action = $_GET['action'] ?? 'default';  // Si l'action n'est pas présente dans l'URL, utiliser 'default'

// Essayer d'exécuter la route en appelant la méthode 'dispatch' du routeur avec l'action récupérée
try {
    $router->dispatch($action);  // Lancer la méthode de routage pour exécuter l'action correspondante
} catch (Exception $e) {
    // Si une exception est levée (par exemple, si l'action n'existe pas ou si un contrôleur/méthode est manquant),
    // afficher une erreur personnalisée à l'utilisateur.
    $errorController = new ErrorController();  // Créer une instance du contrôleur d'erreurs
    $errorController->showError($e->getMessage());  // Appeler la méthode 'showError' du contrôleur d'erreurs et afficher le message
}
?>
