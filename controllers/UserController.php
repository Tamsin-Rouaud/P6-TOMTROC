<?php
// Activation des erreurs pour le débogage (à décommenter en cas de besoin)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/**
 * Contrôleur pour la gestion des utilisateurs.
 *
 * Ce contrôleur gère l'affichage et la mise à jour des informations de l'utilisateur,
 * ainsi que l'authentification (connexion, inscription et déconnexion).
 */
class UserController {

    /**
     * Affiche la page "Mon compte" avec les informations de l'utilisateur, ses livres et la durée d'adhésion.
     *
     * @return void
     */
    public function showMyAccount(): void {
        // Vérifie si l'utilisateur est connecté
        Utils::checkIfUserIsConnected();

        // Récupère les données de l'utilisateur depuis la session
        $userData = $_SESSION['user'];
        $email = $userData['email']; // Extraction de l'email

        try {
            // Récupère l'objet utilisateur depuis la base de données
            $userManager = new UserManager();
            $user = $userManager->findUserByEmail($email);

            // Vérifie que l'utilisateur existe
            if (!$user) {
                throw new Exception("Utilisateur introuvable.");
            }

            // Calcul de la durée d'adhésion
            $membershipDuration = $this->getMembershipDuration($user->getDateCreationUser()->format('Y-m-d'));

            // Récupère les livres appartenant à l'utilisateur
            $bookManager = new BookManager();
            $userBooks = $bookManager->findBooksByUserId((int)$user->getIdUser()) ?? [];

            // Génère et affiche la vue "Mon compte"
            $view = new View("Mon compte");
            $view->render("myAccount", [
                'user' => $user,
                'books' => $userBooks,
                'membershipDuration' => $membershipDuration,
            ]);
        } catch (Exception $e) {
            // Enregistre l'erreur dans le log et redirige vers le formulaire de connexion
            error_log("Erreur lors du chargement de la page Mon compte : " . $e->getMessage());
            Utils::redirect('loginForm');
        }
    }

    /**
     * Affiche le formulaire de modification de la photo de profil.
     *
     * @return void
     */
    public function showProfilePictureForm() {
        // Récupère l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['user']['id'] ?? null;

        // Vérifie que l'utilisateur est connecté
        if (!$userId) {
            Utils::redirect('loginForm');
            exit;
        }

        // Récupère l'utilisateur à partir de l'ID
        $userManager = new UserManager();
        $user = $userManager->findUserById($userId);

        // Affiche la vue de modification de la photo de profil
        $view = new View("Mon avatar");
        $view->render("addProfilePicture", [
            'user' => $user,
        ]);
    }

    /**
     * Affiche le formulaire de connexion et gère le processus d'authentification.
     *
     * @return void
     */
    public function showLoginForm(): void {
        $errors = [];
        $userManager = new UserManager();

        // Traitement du formulaire lors d'une requête POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Utils::request('email');
            $password = Utils::request('password');

            // Valide les données de connexion
            $errors = $userManager->validateUserDataLogin($email, $password);

            if (empty($errors)) {
                $user = $userManager->findUserByEmail($email);

                // Vérifie le mot de passe et connecte l'utilisateur si tout est valide
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

        // Affiche la vue de connexion avec les éventuelles erreurs
        $view = new View('Connexion');
        $view->render('loginForm', ['errors' => $errors]);
    }

    /**
     * Affiche le formulaire d'inscription et gère la création d'un nouvel utilisateur.
     *
     * @return void
     */
    public function showRegisterForm(): void {
        $errors = [];
        $userManager = new UserManager();

        // Traitement du formulaire lors d'une requête POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Utils::request('email');
            $username = Utils::request('username');
            $password = Utils::request('password');

            // Valide les données d'inscription
            $errors = $userManager->validateUserData($email, $username, $password);

            if (empty($errors)) {
                // Crée l'utilisateur en hachant le mot de passe
                $userManager->createUser($username, $email, password_hash($password, PASSWORD_DEFAULT));
                Utils::redirect('loginForm');
            }
        }

        // Affiche la vue d'inscription avec les éventuelles erreurs
        $view = new View('Inscription');
        $view->render('registerForm', ['errors' => $errors]);
    }

    /**
     * Déconnecte l'utilisateur en détruisant la session et redirige vers le formulaire de connexion.
     *
     * @return void
     */
    public function logout(): void {
        session_unset();
        session_destroy();
        Utils::redirect('loginForm');
    }

    /**
     * Calcule la durée d'adhésion à partir de la date de création.
     *
     * @param string $creationDate La date de création de l'utilisateur (format Y-m-d).
     * @return string La durée d'adhésion sous forme textuelle.
     */
    public function getMembershipDuration(string $creationDate): string {
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

    /**
     * Met à jour les informations de l'utilisateur.
     *
     * Récupère les nouvelles données du formulaire, met à jour l'objet utilisateur et la session.
     *
     * @return void
     */
    public function updateUser(): void {
        // Récupère l'ID de l'utilisateur (depuis POST ou session)
        $userId = $_POST['id_user'] ?? $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            header('Location: index.php?action=myAccount&error=Utilisateur%20introuvable');
            exit;
        }

        // Récupère l'utilisateur depuis la base de données
        $userManager = new UserManager();
        $user = $userManager->findUserById($userId);

        if (!$user) {
            header('Location: index.php?action=myAccount&error=Utilisateur%20introuvable');
            exit;
        }

        // Récupère et nettoie les nouvelles informations
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']); // Mot de passe optionnel

        // Met à jour l'objet utilisateur et la session
        $user->setEmail($email);
        $user->setUsername($username);
        $_SESSION['user']['email'] = $user->getEmail();
        $_SESSION['user']['username'] = $user->getUsername();

        // Si un nouveau mot de passe est fourni, le hacher et mettre à jour
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
        }

        // Met à jour l'utilisateur via le gestionnaire et redirige selon le résultat
        if ($userManager->updateUser($user)) {
            header('Location: index.php?action=myAccount&success=Miseàjourréussie');
        } else {
            header('Location: index.php?action=myAccount&error=Miseàjouréchouée');
        }
        exit;
    }

    /**
     * Met à jour la photo de profil de l'utilisateur.
     *
     * Vérifie la présence de l'image, la télécharge, met à jour l'objet utilisateur et redirige avec un message.
     *
     * @return void
     */
    public function updateProfilePicture() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $utils = new Utils();
            $userManager = new UserManager();

            $idUser = $_POST['id_user'] ?? null;
            $image = $_FILES['updateProfileImage'] ?? null;

            if (!$idUser || !$image) {
                header('Location: addProfilePicture.php?error=ID utilisateur ou image manquants');
                exit;
            }

            // Vérifie la validité de la structure du fichier
            if (!is_array($image) || !isset($image['tmp_name'], $image['error'])) {
                header('Location: addProfilePicture.php?error=Erreur de téléchargement de fichier');
                exit;
            }

            // Récupère l'utilisateur
            $user = $userManager->findUserById($idUser);
            if (!$user) {
                header('Location: index.php?action=myAccount&error=Utilisateur introuvable');
                exit;
            }

            // Gestion de l'upload de la nouvelle photo de profil
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

    /**
     * Affiche les détails du profil d'un utilisateur, y compris ses livres et sa durée d'adhésion.
     *
     * @param int $userId L'identifiant de l'utilisateur dont on affiche le profil.
     * @throws Exception Si l'utilisateur n'est pas trouvé.
     * @return void
     */
    public function showProfileDetails($userId) {
        $bookManager = new BookManager();
        $userManager = new UserManager();

        // Récupère l'utilisateur
        $user = $userManager->findUserById($userId);
        if (!$user) {
            throw new Exception("Propriétaire introuvable.");
        }

        // Calcule la durée d'adhésion
        $membershipDuration = $this->getMembershipDuration($user->getDateCreationUser()->format('Y-m-d'));

        // Récupère les livres de l'utilisateur
        $books = $bookManager->findBooksByUserId($userId);

        // Affiche la vue "Détails du profil"
        $view = new View("Détails du profil");
        $view->render("profileDetails", [
            'user' => $user,
            'books' => $books,
            'membershipDuration' => $membershipDuration,
        ]);
    }
}
