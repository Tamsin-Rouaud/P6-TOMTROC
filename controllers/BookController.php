<?php

class BookController {
    
    // Cette méthode est utilisée pour afficher les livres disponibles.
    public function showBooks()
    { 
        $BookManager = new BookManager();
        $message = $BookManager->getBookMessage();  // Récupérer les livres ou message à afficher
        $view = new View('Nos livres à l\'échange');
        $view->render('availableBooks', ['author' => $message]);  // Passer les données à la vue
    }

    public function showAddBookForm() {
        $view = new View('Ajouter un livre');
        $view->render('addBookForm');
    }

    public function addBook() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author_name = $_POST['author_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $owner_id = $_SESSION['user']['id'];
            $is_available = isset($_POST['is_available']) ? 1 : 0;

            $bookManager = new BookManager();
            $bookManager->createBook($title, $author_name, $description, $owner_id, $is_available);

            Utils::redirect('myAccount');
        }
    }

    // Affiche le formulaire de modification d'un livre
    public function showEditBookForm()
    {
        $id = $_GET['id_books'] ?? null;
    
        if ($id) {
            $bookManager = new BookManager();
            $book = $bookManager->getBookById($id);
    
            if ($book) {
                $view = new View('Modifier un livre');
                $view->render('editBookForm', ['book' => $book]);
            } else {
                throw new Exception("Livre non trouvé.");
            }
        } else {
            throw new Exception("ID du livre manquant.");
        }
    }
    

    // Traite la soumission du formulaire de modification
    public function editBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookId = $_GET['id_books'] ?? null;
    
            if (!$bookId) {
                throw new Exception("ID du livre manquant.");
            }
    
            // Validation des données
            $title = $_POST['getBookTitle'] ?? '';
            $author = $_POST['getBookAuthor'] ?? '';
            $description = $_POST['getBookDescription'] ?? '';
            $isAvailable = $_POST['getBookIsAvailable'] ?? 0;
    
            // Mise à jour dans la base de données
            $bookManager = new BookManager();
            $bookManager->updateBook($bookId, $title, $author, $description, $isAvailable);
    
            // Redirection après la mise à jour
            Utils::redirect('myAccount');
        }
    }
    
    public function showLimitedBooks() {
        $bookModel = new BookModel();  // Assurez-vous que cette classe existe
        $books = $bookModel->getLimitedBooks(4);  // Récupère les 4 premiers livres
        require './views/myAccount.php';  // Chargez la vue avec les données
    }

    public function showAllBooks() {
        $bookModel = new BookModel();  // Assurez-vous que cette classe existe
        $books = $bookModel->getAllBooks();  // Récupère tous les livres
        require './views/myAccount.php';  // Chargez la vue avec les données
    }

}

