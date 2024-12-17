<?php
class Router {
    // Tableau pour stocker les routes
    private $routes = [];

    // Méthode pour ajouter une route
    public function addRoute(string $action, string $controller, string $method) {
        // Vérifie si le contrôleur existe
        if (!class_exists($controller)) {
            throw new Exception("Le contrôleur '$controller' n'existe pas.");
        }
    
        // Vérifie si la méthode existe dans le contrôleur
        if (!method_exists($controller, $method)) {
            throw new Exception("La méthode '$method' n'existe pas dans le contrôleur '$controller'.");
        }
    
        // Enregistre la route dans le tableau des routes avec l'action comme clé
        $this->routes[$action] = ['controller' => $controller, 'method' => $method];
    }
    
    // Méthode pour dispatcher (rediriger) vers la méthode du contrôleur approprié
    public function dispatch(string $action) {
        if (!array_key_exists($action, $this->routes)) {
            throw new Exception("Action '$action' non trouvée.");
        }
    
        // Récupération du contrôleur et de la méthode associés
        $controllerName = $this->routes[$action]['controller'];
        $methodName = $this->routes[$action]['method'];
    
        // Vérification de l'existence du contrôleur
        if (!class_exists($controllerName)) {
            throw new Exception("Le contrôleur '$controllerName' n'existe pas.");
        }
    
        // Instanciation du contrôleur
        $controller = new $controllerName();
    
        // Vérification de l'existence de la méthode
        if (!method_exists($controller, $methodName)) {
            throw new Exception("La méthode '$methodName' n'existe pas dans le contrôleur '$controllerName'.");
        }
    
        // Appel de la méthode du contrôleur
        $controller->$methodName();
    }
    
}
?>
