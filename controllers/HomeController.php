<?php

class HomeController {
    private BookManager $bookManager;

    public function __construct() {
        $this->bookManager = new BookManager();
    }

    public function index() {
        // Récupérer les 4 derniers livres ajoutés
        $lastBooks = $this->bookManager->getLastAddedBooks();

        // Charger la vue avec ces livres
        $view = new View('Accueil');
        $view->render('home', [
            'lastBooks' => $lastBooks
        ]);
    }
}
