<?php

class HomeController {
    public function index() {
        $view = new View('Accueil');
        $view->render('home', ['message' => 'Bienvenue sur la page d\'accueil']);
    }
}