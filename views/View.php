<?php

//view/View.php


/**
 * Cette classe génère les vues en fonction de ce que chaque contrôleur lui passe en paramètre. 
 */
class View 
{
    /**
     * Le titre de la page.
     */
    private string $title;
        
    /**
     * Constructeur. 
     * Le constructeur initialise la propriété $title avec le titre de la page.
     * 
     * @param string $title : Le titre de la page.
     */
    public function __construct($title) 
    {
        $this->title = $title;
    }
    
    /**
     * Cette méthode retourne une page complète.
     * Elle prend le nom de la vue et les paramètres envoyés par le contrôleur, génère le contenu et l'affiche dans le template principal.
     * 
     * @param string $viewName : le chemin de la vue demandée par le contrôleur. 
     * @param array $params : les paramètres que le contrôleur a envoyés à la vue. (par exemple, les variables à afficher dans la vue)
     * @return void
     */
    public function render(string $viewName, array $params = []) : void 
    {
        // On s'occupe de la vue envoyée
        $viewPath = $this->buildViewPath($viewName);
        
        // Les deux variables ci-dessous sont utilisées dans le "main.php" qui est le template principal.
        $content = $this->_renderViewFromTemplate($viewPath, $params);
        $title = $this->title;
        
        // On démarre la mise en tampon de sortie et on inclut le template principal
        ob_start();
        require(MAIN_VIEW_PATH);  // Ce fichier doit être le template principal de la page
        echo ob_get_clean();      // On affiche le contenu tamponné et on le vide
    }
    
    /**
     * Coeur de la classe, c'est ici qu'est généré ce que le contrôleur a demandé.
     * Elle charge le fichier de la vue et y insère les variables envoyées.
     * 
     * @param string $viewPath : le chemin de la vue demandée par le contrôleur.
     * @param array $params : les paramètres que le contrôleur a envoyés à la vue.
     * @throws Exception : si la vue n'existe pas.
     * @return string : le contenu de la vue générée.
     */
    private function _renderViewFromTemplate(string $viewPath, array $params = []) : string
    {  
        // On vérifie si le fichier de la vue existe
        if (file_exists($viewPath)) {
            extract($params); // On transforme le tableau de paramètres en variables individuelles accessibles dans le template
            ob_start();        // On démarre la mise en tampon de la sortie
            require($viewPath);  // On inclut la vue demandée
            return ob_get_clean();  // On récupère le contenu tamponné et on le renvoie
        } else {
            throw new Exception("La vue '$viewPath' est introuvable.");
        }
    }

    /**
     * Cette méthode construit le chemin vers la vue demandée.
     * Elle est utilisée pour localiser le fichier de la vue à partir de son nom.
     * 
     * @param string $viewName : le nom de la vue demandée.
     * @return string : le chemin vers le fichier de la vue.
     */
    private function buildViewPath(string $viewName) : string
    {
        // Construit le chemin complet de la vue à partir du nom de la vue
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }


}
