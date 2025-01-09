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
        $bookModel = new BookModel();  
        $books = $bookModel->getAllBooks();  // Récupère tous les livres
        require './views/myAccount.php';  // Charge la vue avec les données
    }


    // Cette méthode permet d'afficher la page contenant le formulaire d'ajout d'un livre 
    public function showAddBookForm() {
        $view = new View('Ajouter un livre');
        $view->render('addBookForm');
    }

    // Cette méthode sert à ajouter un livre ou à mettre à jour les informations d'un livre existant. Elle vérifie que les données fournies sont correctes, s'occupe d'enregistrer ou de remplacer l'image du livre si nécessaire, puis sauvegarde toutes ces informations dans la base de données.
    public function addBook()
{
    // Vérifie si la méthode de requête est POST (soumission de formulaire).
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Si la session n'est pas démarrée, la démarrer.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si un utilisateur est connecté (basé sur la session).
        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            $ownerId = $_SESSION['user']['id']; // Récupère l'ID de l'utilisateur connecté.

            // **1. Validation et traitement des données envoyées par le formulaire**
            $title = trim($_POST['addBookTitle'] ?? '');       // Titre du livre (supprime les espaces inutiles).
            $author = trim($_POST['addBookAuthor'] ?? '');     // Auteur du livre.
            $description = trim($_POST['addBookDescription'] ?? ''); // Description du livre.
            $isAvailable = $_POST['addBookIsAvailable'] ?? 1; // Disponibilité du livre (par défaut : disponible).

            // **2. Gestion de l'image**
            $bookManager = new BookManager(); // Instancie le gestionnaire de livres.

            // Récupère l'ancienne image si le livre existe (mode mise à jour).
            $bookId = $_GET['id_book'] ?? null; // Récupère l'identifiant du livre s'il est fourni.
            $oldImagePath = null;

            if ($bookId) {
                // Si un identifiant de livre est fourni, récupère les détails de ce livre.
                $existingBook = $bookManager->getBookById($bookId);
                $oldImagePath = $existingBook ? $existingBook->getImagePath() : null; // Ancienne image associée.
            }

            // Appelle la méthode utilitaire pour gérer l'upload de l'image.
            $imagePath = Utils::handleImageUpload(
                $_FILES['addBookImage'],  // Fichier envoyé depuis le formulaire.
                'books',                  // Dossier cible pour les livres.
                'defaultBook.png',        // Image par défaut si aucune image n'est fournie.
                $oldImagePath             // Ancienne image à supprimer (si applicable).
            );

            // **3. Validation des données requises**
            if (!empty($title) && !empty($author) && !empty($description)) {
                // Si toutes les données sont valides, crée un nouvel objet `Book`.
                $book = new Book();
                $book->setTitle($title);                  // Définit le titre du livre.
                $book->setAuthorName($author);            // Définit l'auteur.
                $book->setDescription($description);      // Définit la description.
                $book->setIsAvailable($isAvailable);      // Définit la disponibilité.
                $book->setImagePath($imagePath);          // Définit le chemin de l'image.
                $book->setOwnerId($ownerId);              // Définit l'identifiant du propriétaire.

                // Enregistre le livre dans la base de données.
                $bookManager->createBook($book);

                // Redirige l'utilisateur vers sa page "Mon Compte".
                header('Location: index.php?action=myAccount');
                exit; // Arrête l'exécution du script après la redirection.
            } else {
                // Si des champs sont manquants ou invalides, affiche un message d'erreur.
                echo "Erreur : Tous les champs du formulaire ne sont pas remplis.";
            }
        } else {
            // Si aucun utilisateur n'est connecté, affiche une erreur.
            echo "Erreur : Aucun utilisateur connecté.";
        }
    }
}
 
    

    // Affiche le formulaire de modification d'un livre
    public function showEditBookForm()
    {
        $id = $_GET['id_book'] ?? null;
    
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
        $bookId = $_GET['id_book'] ?? null;

        if (!$bookId) {
            throw new Exception("ID du livre manquant.");
        }

        // Récupérer l'ancienne image associée au livre
        $bookManager = new BookManager();
        $existingBook = $bookManager->getBookById($bookId);
        $oldImagePath = $existingBook ? $existingBook->getImagePath() : null;

        // Validation des données du formulaire
        $title = $_POST['getBookTitle'] ?? '';
        $author = $_POST['getBookAuthor'] ?? '';
        $description = $_POST['getBookDescription'] ?? '';
        $isAvailable = $_POST['getBookIsAvailable'] ?? 0;

        // Gestion de l'image
        $imagePath = Utils::handleImageUpload($_FILES['addBookImage'], 'books', 'defaultBook.png', $oldImagePath);

        // Mise à jour du livre
        $bookManager->updateBook($bookId, $title, $author, $description, $isAvailable, $imagePath);

        // Redirection après la mise à jour
        Utils::redirect('myAccount');
    }
}


    

}