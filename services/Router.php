<?php
/**
 * Classe Router
 *
 * Cette classe gère l'enregistrement et le dispatching des routes de l'application.
 * Elle permet d'associer une action à un contrôleur et à une méthode, et de rediriger
 * l'exécution vers la méthode correspondante en fonction de l'URL.
 */
class Router {
    // Tableau associatif pour stocker les routes. La clé est l'action, la valeur est un tableau contenant le contrôleur et la méthode.
    private $routes = [];

    /**
     * Ajoute une route à l'application.
     *
     * Vérifie que le contrôleur et la méthode existent avant de les enregistrer.
     *
     * @param string $action L'action à associer à la route.
     * @param string $controller Le nom du contrôleur.
     * @param string $method La méthode du contrôleur à appeler.
     * @throws Exception Si le contrôleur ou la méthode n'existe pas.
     * @return void
     */
    public function addRoute(string $action, string $controller, string $method) {
        // Vérifie que la classe du contrôleur existe
        if (!class_exists($controller)) {
            throw new Exception("Le contrôleur '$controller' n'existe pas.");
        }
    
        // Vérifie que la méthode existe dans le contrôleur
        if (!method_exists($controller, $method)) {
            throw new Exception("La méthode '$method' n'existe pas dans le contrôleur '$controller'.");
        }
    
        // Enregistre la route dans le tableau avec l'action comme clé
        $this->routes[$action] = ['controller' => $controller, 'method' => $method];
    }
    
    /**
     * Dispatch (redirige) l'exécution vers la méthode du contrôleur associée à l'action.
     *
     * Récupère l'action demandée, instancie le contrôleur associé et appelle la méthode.
     * Si un paramètre 'id' est présent dans l'URL, il est transmis à la méthode.
     *
     * @param string $action L'action à dispatcher.
     * @throws Exception Si la route n'existe pas.
     * @return void
     */
    public function dispatch(string $action) {
        // Vérifie que la route existe
        if (!isset($this->routes[$action])) {
            throw new Exception("La route \"$action\" n'existe pas.");
        }
    
        // Récupère les informations associées à la route
        $route = $this->routes[$action];
        $controllerName = $route['controller'];
        $methodName = $route['method'];
    
        // Instancie le contrôleur
        $controller = new $controllerName();
    
        // Récupère un paramètre 'id' (ou d'autres paramètres si nécessaire) depuis l'URL
        $id = $_GET['id'] ?? null;
    
        // Appelle la méthode du contrôleur en passant l'ID si disponible, sinon sans paramètre
        if ($id !== null) {
            $controller->$methodName((int)$id);
        } else {
            $controller->$methodName();
        }
    }
}
