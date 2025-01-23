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

public function showProfilePictureForm() {
    // Récupérer l'utilisateur
    $userId = $_SESSION['user']['id'] ?? null;

    // Vérifier si l'utilisateur est connecté
    if (!$userId) {
        Utils::redirect('loginForm');
        exit;
    }

    // Récupérer l'utilisateur à partir de l'ID
    $userManager = new UserManager();
    $user = $userManager->findUserById($userId);

    // Générer la vue de modification de la photo de profil
    $view = new View("Mon avatar");
    $view->render("addProfilePicture", [
        'user' => $user, // Passer l'objet utilisateur à la vue
    ]);
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

    public function updateUser(): void
{
    // Assurez-vous que l'ID de l'utilisateur est passé via le formulaire ou la session
    $userId = $_POST['id_user'] ?? $_SESSION['user']['id'] ?? null;

    if (!$userId) {
        // Gestion d'erreur si l'ID utilisateur est manquant
        header('Location: index.php?action=myAccount&error=Utilisateur%20introuvable');
        exit;
    }

    // Récupérer l'utilisateur depuis la base de données
    $userManager = new UserManager();
    $user = $userManager->findUserById($userId);

    if (!$user) {
        // Gestion d'erreur si l'utilisateur n'existe pas
        header('Location: index.php?action=myAccount&error=Utilisateur%20introuvable');
        exit;
    }

    // Mettre à jour les informations de l'utilisateur
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Nouveau mot de passe (optionnel)

    // Mettre à jour la session avec les nouvelles informations de l'utilisateur
// $_SESSION['user']['email'] = $user->getEmail();
// $_SESSION['user']['username'] = $user->getUsername();

    $user->setEmail($email);
    $user->setUsername($username);
    $_SESSION['user']['email'] = $user->getEmail();
    $_SESSION['user']['username'] = $user->getUsername();
    // Vérifier si un nouveau mot de passe a été fourni
    if (!empty($password)) {
        // Hacher le mot de passe avant de le mettre à jour
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
    }

    // Appeler la méthode updateUser du manager avec l'objet User
    if ($userManager->updateUser($user)) {
        // Redirection avec un message de succès
        header('Location: index.php?action=myAccount&success=Miseàjourréussie');
    } else {      // Gestion d'erreur si la mise à jour échoue
        header('Location: index.php?action=myAccount&error=Miseàjouréchouée');
    }

    exit;
}

    public function updateProfilePicture()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $utils = new Utils();
            $userManager = new UserManager();
    
            $idUser = $_POST['id_user'] ?? null;
            $image = $_FILES['updateProfileImage'] ?? null;
    
            if (!$idUser || !$image) {
                header('Location: addProfilePicture.php?error=ID utilisateur ou image manquants');
                exit;
            }
    
            // Vérification de la structure de $_FILES
            if (!is_array($image) || !isset($image['tmp_name'], $image['error'])) {
                header('Location: addProfilePicture.php?error=Erreur de téléchargement de fichier');
                exit;
            }
    
            $user = $userManager->findUserById($idUser);
            if (!$user) {
                header('Location: index.php?action=myAccount&error=Utilisateur introuvable');
                exit;
            }
    
            $uploadResult = $utils->handleImageUpload($image, 'users', 'defaultAvatar.png', $user->getImagePathUser());
    
            if (is_array($uploadResult) && isset($uploadResult['success']) && $uploadResult['success']) {
                $user->setImagePathUser($uploadResult['path']);
                $userManager->updateUser($user);
                header('Location: index.php?action=myAccount&success=Photo mise à jour');
            } else {
                $error = $uploadResult['error'] ?? 'Erreur inconnue lors du téléchargement de l\'image';
                header("Location: addProfilePicture.php?error=$error");
            }
        } else {
            header('Location: addProfilePicture.php?error=Requête invalide');
        }
    }

    
}