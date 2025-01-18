<?php

class BookController {

    // Cette méthode est utilisée pour afficher les livres de la page publique pour tous les utilisateurs
    public function showBooks()
    { 
        $BookManager = new BookManager();
        $books = $BookManager->getAllBooks();  // Récupére les livres à afficher
        $view = new View('Nos livres à l\'échange');
        $view->render('availableBooks', ['books' => $books]);  // Passe les données à la vue
    }

    // Cette méthode est destinée à afficher une page privé myAccount pour tous les livres liés au compte d'un utilisateur connecté
    public function showAllBooks() {
        // Récupération des livres liés à l'utilisateur connecté
        $bookModel = new BookManager();
        
        
        $userId = $_SESSION['id_user'];
        $books = $bookModel->getBooksByUser($userId);
    
        
        $view = new View('Mon compte');
        $view->render('myAccount', ['books' => $books]);
    }
    

    /**
     * Affiche le formulaire d'ajout de livre.
     * @return void
     */
    public function showAddBookForm(): void {
        $view = new View('Ajouter un livre');
        $view->render('addBookForm');
    }

    /**
     * Gère l'ajout d'un livre.
     * @return void
     */
    public function addBook(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Utils::checkIfUserIsConnected();

            $ownerId = $_SESSION['user']['id'] ?? null;
            if (!$ownerId) {
                echo "Erreur : Aucun utilisateur connecté.";
                return;
            }

            $title = trim($_POST['addBookTitle'] ?? '');
            $author = trim($_POST['addBookAuthor'] ?? '');
            $description = trim($_POST['addBookDescription'] ?? '');
            $isAvailable = $_POST['addBookIsAvailable'] ?? 1;

            if (empty($title) || empty($author) || empty($description)) {
                echo "Erreur : Tous les champs du formulaire ne sont pas remplis.";
                return;
            }

            $imagePath = Utils::handleImageUpload(
                $_FILES['addBookImage'] ?? null,
                'books',
                'defaultBook.png'
            );

            $book = new Book();
            $book->setTitle($title);
            $book->setAuthorName($author);
            $book->setDescription($description);
            $book->setIsAvailable($isAvailable);
            $book->setImagePath($imagePath);
            $book->setOwnerId($ownerId);

            $bookManager = new BookManager();
            $bookManager->createBook($book);

            header('Location: index.php?action=myAccount');
            exit;
        }
    }

    /**
     * Gère la suppression d'un livre.
     * @return void
     */
    public function deleteBook(): void {
        Utils::checkIfUserIsConnected();

        $bookId = $_GET['id_book'] ?? null;
        if (!$bookId) {
            header('Location: index.php?action=myAccount');
            exit;
        }

        $bookManager = new BookManager();
        $book = $bookManager->findBookById((int) $bookId);

        if ($book && $book->getOwnerId() === $_SESSION['user']['id']) {
            if ($book->getImagePath() !== 'uploads/books/defaultBook.png') {
                Utils::deleteImage($book->getImagePath());
            }

            $bookManager->deleteBookById((int) $bookId);
        }

        header('Location: index.php?action=myAccount');
        exit;
    }

    /**
     * Gère la modification d'un livre.
     * @return void
     */
    public function editBook(): void {
        Utils::checkIfUserIsConnected();

        $bookId = $_GET['id_book'] ?? null;
        if (!$bookId) {
            header('Location: index.php?action=myAccount');
            exit;
        }

        $bookManager = new BookManager();
        $book = $bookManager->findBookById((int) $bookId);

        if (!$book || $book->getOwnerId() !== $_SESSION['user']['id']) {
            header('Location: index.php?action=myAccount');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['getBookTitle'] ?? '');
            $author = trim($_POST['getBookAuthor'] ?? '');
            $description = trim($_POST['getBookDescription'] ?? '');
            $isAvailable = isset($_POST['getBookIsAvailable']) ? (int) $_POST['getBookIsAvailable'] : 0;

            $imagePath = $book->getImagePath();
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = Utils::handleImageUpload(
                    $_FILES['image'],
                    'books',
                    'defaultBook.png',
                    $book->getImagePath()
                );
            }

            $book->setTitle($title);
            $book->setAuthorName($author);
            $book->setDescription($description);
            $book->setIsAvailable($isAvailable);
            $book->setImagePath($imagePath);

            $bookManager->updateBook($book);

            header('Location: index.php?action=myAccount');
            exit;
        }

        $view = new View("Modifier un livre");
        $view->render("editBookForm", ['book' => $book]);
    }
}