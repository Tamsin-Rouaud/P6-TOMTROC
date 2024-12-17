<?php

class ErrorController {
    public function showError(string $message) {
        $view = new View('Erreur');
        $view->render('error', ['message' => $message]);
    }
}
