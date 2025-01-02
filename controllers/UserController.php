<?php

class UserController {   

        /**
     * Affiche la page d'administration.
     * @return void
     */
    public function showMyAccount() : void
{
    // Vérifie si l'utilisateur est connecté
    $this->checkIfUserIsConnected();
    
    // Récupère les informations utilisateur directement depuis la session
    $user = $_SESSION['user'];
    
    // Récupération des livres associés à cet utilisateur
    $BookManager = new BookManager();
    $userBooks = $BookManager->findBooksByUserId($user['id']);
    
    // Affiche la vue "Mon compte"
    $view = new View("Mon compte");
    $view->render("myAccount", [
        'user' => $user,
        'books' => $userBooks,
    ]);
}



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
                    // Stockage des informations utilisateur dans la session
                    $_SESSION['user'] = [
                        'id' => $user['id_users'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                    ];
                    header('Location: index.php?action=myAccount'); // Redirige vers l'accueil
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
    
    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected() : void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['user'])) {
        Utils::redirect("loginForm");
    }
}


    /**
     * Affiche le formulaire de connexion.
     * @return void
     */
    public function displayConnectionForm() : void 
    {
        // Affichage du formulaire de connexion.
        $view = new View("Connexion");
        $view->render("loginForm");
    }

    /**
     * Connexion de l'utilisateur après validation des informations.
     * @return void
     */
}
