<?php

/**
 * Contrôleur de la page d'accueil.
 *
 * Ce contrôleur récupère les derniers livres ajoutés et les transmet à la vue de l'accueil.
 */
class HomeController {
    // Gestionnaire pour accéder aux données des livres
    private BookManager $bookManager;

    /**
     * Constructeur : initialise le BookManager.
     */
    public function __construct() {
        $this->bookManager = new BookManager();
    }

    /**
     * Méthode d'affichage de la page d'accueil.
     *
     * Récupère les 4 derniers livres ajoutés et les affiche via la vue "home".
     */
    public function index() {
        // Récupérer les 4 derniers livres ajoutés
        $lastBooks = $this->bookManager->getLastAddedBooks();

        // Instanciation de la vue avec le titre "Accueil"
        $view = new View('Accueil');

        // Rendu de la vue "home" en transmettant les derniers livres récupérés
        $view->render('home', [
            'lastBooks' => $lastBooks
        ]);
    }
}
