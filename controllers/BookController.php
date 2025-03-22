<?php

/**
 * Contrôleur pour la gestion des livres.
 * Il orchestre les interactions entre la vue, le modèle et les services liés aux livres.
 */
class BookController {

    // Gestionnaires pour manipuler les livres et les utilisateurs
    private BookManager $bookManager;
    private UserManager $userManager;

    /**
     * Constructeur : instancie les gestionnaires nécessaires.
     */
    public function __construct() {
        $this->bookManager = new BookManager();
        $this->userManager = new UserManager(); // Initialisation de UserManager
    }

    /**
     * Redirige l'utilisateur vers la page de son compte.
     */
    private function redirectToMyAccount(): void {
        header('Location: index.php?action=myAccount');
        exit;
    }

    // ----------------- Méthodes de lecture -----------------

    /**
     * Affiche tous les livres associés à l'utilisateur connecté.
     */
    public function showAllBooks(): void {
        $userId = $_SESSION['id_user'] ?? null;
        if (!$userId) {
            echo "Erreur : Vous devez être connecté pour voir vos livres.";
            return;
        }

        $books = $this->bookManager->findBooksByUserId($userId);
        $view = new View('Mon compte');
        $view->render('myAccount', ['books' => $books]);
    }

    /**
     * Affiche les détails d'un livre et du propriétaire.
     *
     * @param int $id L'identifiant du livre.
     * @throws Exception si le livre ou le propriétaire est introuvable.
     */
    public function showBookDetails($id) {
        $userManager = new UserManager();
    
        // Récupère le livre à partir de son ID
        $book = $this->bookManager->findBookById($id);
    
        if (!$book) {
            throw new Exception("Livre introuvable avec l'ID : $id");
        }
    
        // Récupère l'ID du propriétaire et ses informations
        $ownerId = $book->getOwnerId();
        $user = $userManager->findUserById($ownerId);
    
        if (!$user) {
            throw new Exception("Propriétaire introuvable pour ce livre");
        }
    
        // Affiche la vue avec les données du livre et du propriétaire
        $view = new View("Afficher un livre");
        $view->render("bookDetails", [
            'book' => $book,
            'user' => $user
        ]);
    }

    /**
     * Affiche le formulaire d'ajout de livre.
     */
    public function showAddBookForm(): void {
        $view = new View('Ajouter un livre');
        $view->render('addBookForm');
    }

    // ----------------- Méthodes de modification -----------------

    /**
     * Affiche le formulaire d'édition d'un livre et gère sa mise à jour.
     */
    public function editBook(): void {
        // Vérifie que l'utilisateur est connecté
        Utils::checkIfUserIsConnected();

        $bookId = $_GET['id_book'] ?? null;
        if (!$bookId) {
            $this->redirectToMyAccount();
        }

        $book = $this->bookManager->findBookById((int) $bookId);
        // Vérifie que le livre existe et que l'utilisateur connecté est bien le propriétaire
        if (!$book || $book->getOwnerId() !== $_SESSION['user']['id']) {
            $this->redirectToMyAccount();
        }

        // Traitement du formulaire de modification en méthode POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $book->getImagePath();
           
            // Gestion de l'upload de l'image si une nouvelle image est fournie
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = Utils::handleImageUpload(
                    $_FILES['image'],
                    'books',
                    'defaultBook.png',
                    $book->getImagePath()
                );
            }

            // Mise à jour des informations du livre
            $book->setTitle(trim($_POST['getBookTitle']));
            $book->setAuthorName(trim($_POST['getBookAuthor']));
            $book->setDescription(trim($_POST['getBookDescription']));
            $book->setIsAvailable($_POST['getBookIsAvailable'] ?? 1);
            $book->setImagePath($imagePath);
            
            $this->bookManager->updateBook($book);
            $this->redirectToMyAccount();
        }

        // Affiche le formulaire d'édition du livre
        $view = new View("Modifier un livre");
        $view->render("editBookForm", ['book' => $book]);
    }

    // ----------------- Méthodes de création -----------------

    /**
     * Ajoute un nouveau livre.
     * Valide les données du formulaire, gère l'upload de l'image et enregistre le livre.
     */
    public function addBook() {
        // Vérifie que la méthode HTTP utilisée est POST (soumission du formulaire)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifie qu'un utilisateur est connecté
            if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
                $ownerId = $_SESSION['user']['id'];
                
                // Récupération et nettoyage des données du formulaire
                $title = trim($_POST['addBookTitle'] ?? '');
                $author = trim($_POST['addBookAuthor'] ?? '');
                $description = trim($_POST['addBookDescription'] ?? '');
                $isAvailable = $_POST['addBookIsAvailable'] ?? 1;
                
                // Gestion de l'image : upload ou utilisation de l'image par défaut
                
                $imageUploadResult = Utils::handleImageUpload(
                    $_FILES['addBookImage'] ?? null,
                    'books',
                    'defaultBook.png'
                );
                if ($imageUploadResult['success']) {
                    $imagePath = $imageUploadResult['path'];
                } else {
                    $imagePath = "./uploads/books/defaultBook.png";
                }
                
                // Vérifie que les champs obligatoires sont remplis
                if (!empty($title) && !empty($author) && !empty($description)) {
                    // Création et configuration d'un nouvel objet Book
                    $book = new Book();
                    $book->setTitle($title);
                    $book->setAuthorName($author);
                    $book->setDescription($description);
                    $book->setIsAvailable($isAvailable);
                    $book->setImagePath($imagePath);
                    $book->setOwnerId($ownerId);
    
                    // Enregistrement du livre dans la base de données
                    $this->bookManager->createBook($book);
    
                    // Redirection vers la page "Mon Compte" après ajout
                    header('Location: index.php?action=myAccount');
                    exit;
                } else {
                    echo "Erreur : Tous les champs du formulaire ne sont pas remplis.";
                }
            } else {
                echo "Erreur : Aucun utilisateur connecté.";
            }
        }
    }

    // ----------------- Autres méthodes de lecture -----------------

    /**
     * Affiche tous les livres disponibles pour l'échange.
     */
    public function showBooks(): void {
        $books = $this->bookManager->getAllBooks();
        $view = new View('Nos livres à l\'échange');
        $view->render('availableBooks', ['books' => $books]);
    }

    // ----------------- Méthodes de mise à jour -----------------

    /**
     * Met à jour les informations d'un livre existant.
     */
    public function updateBook() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_book = $_POST['id_book'] ?? null;
            $title = $_POST['getBookTitle'] ?? '';
            $author_name = $_POST['getBookAuthor'] ?? '';
            $description = $_POST['getBookDescription'] ?? '';
            $is_available = isset($_POST['getBookIsAvailable']) ? (int)$_POST['getBookIsAvailable'] : 0;
    
            
            $existingBook = $this->bookManager->findBookById($id_book);
    
            if (!$existingBook) {
                header("Location: index.php?action=myAccount&error=book_not_found");
                exit;
            }
    
            // Gestion de l'image : récupération du chemin actuel et mise à jour si nécessaire
            $currentImagePath = $existingBook->getImagePath();
            if (isset($_FILES['updateBookImage']) && $_FILES['updateBookImage']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = Utils::handleImageUpload(
                    $_FILES['updateBookImage'],
                    'books',
                    'defaultBook.png',
                    $currentImagePath
                );
    
                if ($uploadResult['success']) {
                    $currentImagePath = $uploadResult['path'];
                } else {
                    error_log("Erreur lors de l'upload de l'image : " . $uploadResult['error']);
                }
            }
    
            // Instanciation d'un objet Book et mise à jour de ses propriétés
            $book = new Book();
            $book->setIdBook($id_book);
            $book->setTitle($title);
            $book->setAuthorName($author_name);
            $book->setDescription($description);
            $book->setIsAvailable($is_available);
            $book->setImagePath($currentImagePath);
    
            // Tentative de mise à jour dans la base de données
            try {
                $this->bookManager->updateBook($book);
                header("Location: index.php?action=myAccount&success=update");
                exit;
            } catch (Exception $e) {
                error_log("Erreur lors de la mise à jour du livre : " . $e->getMessage());
                header("Location: index.php?action=myAccount&error=update_failed");
                exit;
            }
        } else {
            header("Location: index.php?action=myAccount");
            exit;
        }
    }

    // ----------------- Méthodes de suppression -----------------

    /**
     * Supprime un livre à partir de son ID.
     */
    public function deleteBook(): void {
        if (isset($_GET['id_book']) && is_numeric($_GET['id_book'])) {
            $bookId = (int)$_GET['id_book'];
    
            
            $book = $this->bookManager->findBookById($bookId);
    
            if ($book) {
                // Supprime le fichier image si ce n'est pas l'image par défaut
                if ($book->getImagePath() !== './uploads/books/defaultBook.png' && 
                    file_exists($book->getImagePath())) {
                    unlink($book->getImagePath());
                }
    
                // Supprime le livre de la base de données
                $this->bookManager->deleteBook($bookId);
    
                header("Location: index.php?action=myAccount&message=deleted");
                exit;
            } else {
                echo "Erreur : Livre introuvable.";
            }
        } else {
            header("Location: index.php?action=myAccount");
            exit;
        }
    }

    // ----------------- Autres fonctionnalités -----------------

    /**
     * Affiche les derniers livres ajoutés.
     */
    public function showLastAddedBooks() {
        
        $lastBooks = $this->bookManager->getLastAddedBooks();
    
        $view = new View('Accueil');
        $view->render('home', ['lastBooks' => $lastBooks]);
    }

    /**
     * Gère la recherche de livres par titre ou auteur.
     * Redirige vers la page des détails si un seul livre est trouvé,
     * ou affiche une liste de résultats sinon.
     */
    public function searchResults() {
        // Récupère le terme de recherche
        $searchTerm = Utils::request('search', '');
    
        if (empty($searchTerm)) {
            Utils::redirect('availableBooks');
            return;
        }
    
        // Recherche des livres correspondants dans la base de données
        $books = $this->bookManager->searchBooksByTitleOrAuthor($searchTerm);
    
        if (count($books) === 1) {
            // Redirige directement vers la page de détails du livre si un seul résultat est trouvé
            $book = $books[0];
            Utils::redirect('bookDetails', ['id' => $book->getIdBook()]);
            return;
        } elseif (empty($books)) {
            // Affiche un message d'erreur si aucun livre n'est trouvé
            $view = new View('Aucun résultat');
            $view->render('searchResults', [
                'books' => [],
                'searchTerm' => $searchTerm,
                'errorMessage' => 'Aucun livre ne correspond à votre recherche.'
            ]);
            return;
        }
    
        // Affiche la liste des livres correspondants si plusieurs résultats sont trouvés
        $view = new View('Résultats de recherche');
        $view->render('searchResults', [
            'books' => $books,
            'searchTerm' => $searchTerm,
            'errorMessage' => ''
        ]);
    }
}
