<?php

class UserController {   

    /**
     * Affiche la page d'administration.
     * @return void
     */
    public function showMyAccount(): void
{
    // Vérifie si l'utilisateur est connecté
    Utils::checkIfUserIsConnected();

    // Récupère l'utilisateur connecté depuis la session
    $userData = $_SESSION['user'];
    $email = $userData['email']; // Extrait l'email depuis la session
    
    try {
        // Récupère l'objet utilisateur depuis la base de données
        $userManager = new UserManager();
        $user = $userManager->findUserByEmail($email);

        // Vérifie si l'utilisateur existe
        if (!$user) {
            throw new Exception("Utilisateur introuvable.");
        }

        // Calcul de la durée d'adhésion
        $membershipDuration = $this->getMembershipDuration($user->getDateCreationUser()->format('Y-m-d'));


        // Récupère les livres de l'utilisateur
        $bookManager = new BookManager();
        $userBooks = $bookManager->findBooksByUserId((int)$user->getIdUser()) ?? [];

        // Génère la vue
        $view = new View("Mon compte");
        $view->render("myAccount", [
            'user' => $user, // Objet utilisateur
            'books' => $userBooks, // Livres appartenant à l'utilisateur
            'membershipDuration' => $membershipDuration, // Durée d'adhésion calculée
        ]);
    } catch (Exception $e) {
        // Log de l'erreur pour le débogage
        error_log("Erreur lors du chargement de la page Mon compte : " . $e->getMessage());

        // Redirection vers la page de connexion en cas d'erreur
        Utils::redirect('loginForm');
    }
}

    public function showLoginForm(): void
    {
        $errors = [];
        $userManager = new UserManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Utils::request('email');
            $password = Utils::request('password');

            $errors = $userManager->validateUserDataLogin($email, $password);

            if (empty($errors)) {
                $user = $userManager->findUserByEmail($email);

                if ($user && password_verify(trim($password), $user->getPassword())) {
                   
                    $_SESSION['user'] = [
                        'id' => $user->getIdUser(),
                        'username' => $user->getUsername(),
                        'email' => $user->getEmail(),
                    ];
                    
                    Utils::redirect('myAccount');
                } else {
                    $errors[] = "Email ou mot de passe incorrect.";
                }
            }
        }

        $view = new View('Connexion');
        $view->render('loginForm', ['errors' => $errors]);
    }

    public function showRegisterForm(): void
    {
        $errors = [];
        $userManager = new UserManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Utils::request('email');
            $username = Utils::request('username');
            $password = Utils::request('password');

            $errors = $userManager->validateUserData($email, $username, $password);

            if (empty($errors)) {
                $userManager->createUser($username, $email, password_hash($password, PASSWORD_DEFAULT));
                Utils::redirect('loginForm');
            }
        }

        $view = new View('Inscription');
        $view->render('registerForm', ['errors' => $errors]);
    }

    public function logout(): void
    {

        session_unset();
        session_destroy();

        Utils::redirect('loginForm');
    }

    public function getMembershipDuration(string $creationDate): string
    {
        $creationDateTime = new DateTime($creationDate);
        $currentDateTime = new DateTime();

        $interval = $creationDateTime->diff($currentDateTime);

        $durationParts = [];
        if ($interval->y > 0) {
            $durationParts[] = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
        }
        if ($interval->m > 0) {
            $durationParts[] = $interval->m . ' mois';
        }
        if ($interval->d > 0) {
            $durationParts[] = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');
        }

        if (count($durationParts) > 1) {
            $lastPart = array_pop($durationParts);
            return implode(', ', $durationParts) . ' et ' . $lastPart;
        }

        return !empty($durationParts) ? implode(', ', $durationParts) : 'moins d\'un jour';
    }
}