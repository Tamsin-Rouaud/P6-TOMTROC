<?php

class UserController {

    public function showRegister() {
        $errors = [];
        $userManager = new UserManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $confirmPassword = $_POST['confirm_password'] ?? null;

            // Validation des données
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Veuillez fournir une adresse email valide.";
            }
            if (empty($password) || strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
            }
            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }
            if ($userManager->emailExists($email)) {
                $errors[] = "Cet email est déjà enregistré.";
            }

            // Si aucune erreur, on crée l'utilisateur
            if (empty($errors)) {
                $userManager->createUser($email, password_hash($password, PASSWORD_DEFAULT));
                header('Location: /inscription-reussie');
                exit;
            }
        }

        // Afficher la vue avec les erreurs (le cas échéant)
        $view = new View('Inscription');
        $view->render('register', ['errors' => $errors]);
    }
}
