<?php
// view/View.php

/**
 * Classe View
 *
 * Cette classe est responsable de la génération des vues.
 * Elle prend en charge l'injection des variables passées par les contrôleurs
 * et intègre le contenu généré dans le template principal.
 */
class View 
{
    /**
     * Le titre de la page.
     *
     * @var string
     */
    private string $title;
        
    /**
     * Constructeur.
     *
     * Initialise la propriété $title avec le titre de la page.
     *
     * @param string $title Le titre de la page.
     */
    public function __construct($title) 
    {
        $this->title = $title;
    }
    
    /**
     * Génère et affiche la page complète.
     *
     * Cette méthode construit le chemin vers la vue demandée, y injecte les variables
     * fournies par le contrôleur, puis intègre le contenu généré dans le template principal.
     *
     * @param string $viewName Le nom (ou chemin relatif) de la vue à afficher.
     * @param array $params Les variables à injecter dans la vue.
     * @return void
     */
    public function render(string $viewName, array $params = []) : void 
    {
        // Construit le chemin complet vers le fichier de la vue
        $viewPath = $this->buildViewPath($viewName);
        
        // Génère le contenu de la vue en injectant les paramètres
        $content = $this->_renderViewFromTemplate($viewPath, $params);
        // Récupère le titre de la page pour l'affichage dans le template principal
        $title = $this->title;
        
        // Démarre la mise en tampon de sortie et inclut le template principal
        ob_start();
        require(MAIN_VIEW_PATH);  // MAIN_VIEW_PATH doit pointer vers le template principal (ex: views/templates/main.php)
        echo ob_get_clean();      // Affiche et vide le contenu tamponné
    }
    
    /**
     * Génère le contenu de la vue à partir d'un fichier template.
     *
     * Cette méthode charge le fichier de la vue, injecte les variables passées en paramètres
     * (via extract) et retourne le contenu généré.
     *
     * @param string $viewPath Le chemin complet vers le fichier de la vue.
     * @param array $params Les variables à injecter dans la vue.
     * @throws Exception Si le fichier de la vue n'existe pas.
     * @return string Le contenu généré par la vue.
     */
    private function _renderViewFromTemplate(string $viewPath, array $params = []) : string
    {  
        // Vérifie si le fichier de la vue existe
        if (file_exists($viewPath)) {
            // Transforme le tableau de paramètres en variables accessibles dans la vue
            extract($params);
            // Démarre la mise en tampon de sortie
            ob_start();
            // Inclut le fichier de la vue
            require($viewPath);
            // Retourne le contenu mis en tampon et le vide
            return ob_get_clean();
        } else {
            throw new Exception("La vue '$viewPath' est introuvable.");
        }
    }

    /**
     * Construit le chemin complet vers la vue demandée.
     *
     * La méthode utilise la constante TEMPLATE_VIEW_PATH pour localiser le fichier.
     *
     * @param string $viewName Le nom de la vue (sans extension).
     * @return string Le chemin complet vers le fichier de la vue.
     */
    private function buildViewPath(string $viewName) : string
    {
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }
}
