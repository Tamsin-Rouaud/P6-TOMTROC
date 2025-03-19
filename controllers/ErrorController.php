<?php

/**
 * Contrôleur dédié à la gestion des erreurs.
 * 
 * Ce contrôleur est responsable d'afficher les messages d'erreur en redirigeant
 * l'utilisateur vers une vue spécifique qui présente le message d'erreur.
 */
class ErrorController {
    /**
     * Affiche une erreur à l'utilisateur.
     *
     * @param string $message Le message d'erreur à afficher.
     */
    public function showError(string $message) {
        // Création d'une vue avec le titre 'Erreur'
        $view = new View('Erreur');
        // Rendu de la vue 'error' en passant le message d'erreur en paramètre
        $view->render('error', ['message' => $message]);
    }
}
