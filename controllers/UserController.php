<?php

class UserController {

    


    public function showLoginForm() {
        $errors = [];
        $userManager = new UserManager();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
    
            // Validation des données
            $errors = $userManager->validateUserDataLogin($email, $password);
    
            if (empty($errors)) {
                $user = $userManager->findUserByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id_users'];
                    header('Location: index.php'); // Redirige vers l'accueil
                    exit;
                } else {
                    $errors[] = "Email ou mot de passe incorrect.";
                }
            }
        }
    
        $view = new View('Connexion');
        $view->render('loginForm', ['errors' => $errors]);
    }
    

    public function showRegisterForm() {
        $errors = [];
        $userManager = new UserManager();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
    
            // Validation des données
            $errors = $userManager->validateUserData($email, $username, $password);
    
            if (empty($errors)) {
                $userManager->createUser($username, $email, password_hash($password, PASSWORD_DEFAULT));
                header('Location: index.php?action=registerForm'); // Redirige vers le formulaire de connexion
                exit;
            }
        }
    
        $view = new View('Inscription');
        $view->render('registerForm', ['errors' => $errors]);
    }
    
    
}
