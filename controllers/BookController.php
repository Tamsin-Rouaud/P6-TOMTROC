<?php

class BookController {

    private BookManager $bookManager;

    public function __construct() {
        $this->bookManager = new BookManager();
    }

    private function redirectToMyAccount(): void {
        header('Location: index.php?action=myAccount');
        exit;
    }

    private function validateBookForm(array $data): bool {
        return !empty($data['addBookTitle']) && 
               !empty($data['addBookAuthor']) && 
               !empty($data['addBookDescription']);
    }

    

    public function showAllBooks(): void {
        $userId = $_SESSION['id_user'] ?? null;
        if (!$userId) {
            echo "Erreur : Vous devez être connecté pour voir vos livres.";
            return;
        }

        $books = $this->bookManager->getBooksByUser($userId);
        $view = new View('Mon compte');
        $view->render('myAccount', ['books' => $books]);
    }

    public function showAddBookForm(): void {
        $view = new View('Ajouter un livre');
        $view->render('addBookForm');
    }

    public function editBook(): void { //Modifier le nom pour showEditBookForm
        Utils::checkIfUserIsConnected();

        $bookId = $_GET['id_book'] ?? null;
        
        if (!$bookId) {
            $this->redirectToMyAccount();
        }

        $book = $this->bookManager->findBookById((int) $bookId);
        
        if (!$book || $book->getOwnerId() !== $_SESSION['user']['id']) {
        
            $this->redirectToMyAccount();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $imagePath = $book->getImagePath();
           
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = Utils::handleImageUpload(
                    $_FILES['image'],
                    'books',
                    'defaultBook.png',
                    $book->getImagePath()
                );
            }

            $book->setTitle(trim($_POST['getBookTitle']));
            $book->setAuthorName(trim($_POST['getBookAuthor']));
            $book->setDescription(trim($_POST['getBookDescription']));
            $book->setIsAvailable($_POST['getBookIsAvailable'] ?? 1);
            $book->setImagePath($imagePath);
            
            $this->bookManager->updateBook($book);
            
            $this->redirectToMyAccount();
        }

        $view = new View("Modifier un livre");
        $view->render("editBookForm", ['book' => $book]);
    }



// CREATE

public function addBook()
 {
     // Vérifie si la méthode de requête est POST (soumission de formulaire).
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
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
                                    
            $imageUploadResult = Utils::handleImageUpload(
                $_FILES['addBookImage'] ?? null, // Fichier envoyé
                'books',                         // Dossier cible
                'defaultBook.png',               // Image par défaut
                // $oldImagePath                    // Ancienne image (si applicable)
            );
            // Vérifiez si l'upload a réussi avant d'extraire le chemin
if ($imageUploadResult['success']) {
    $imagePath = $imageUploadResult['path']; // Récupère uniquement le chemin
} else {
    // Gérez le cas où l'upload échoue, par exemple en définissant une image par défaut
    $imagePath = "./uploads/books/defaultBook.png";
}
                         
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
    

// READ
    public function showBooks(): void {
        $books = $this->bookManager->getAllBooks();
        $view = new View('Nos livres à l\'échange');
        $view->render('availableBooks', ['books' => $books]);
    }


// UPDATE
public function updateBook()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_book = $_POST['id_book'] ?? null;
        $title = $_POST['getBookTitle'] ?? '';
        $author_name = $_POST['getBookAuthor'] ?? '';
        $description = $_POST['getBookDescription'] ?? '';
        $is_available = isset($_POST['getBookIsAvailable']) ? (int)$_POST['getBookIsAvailable'] : 0;

        $bookManager = new BookManager();
        $existingBook = $bookManager->findBookById($id_book);

        if (!$existingBook) {
            header("Location: index.php?action=myAccount&error=book_not_found");
            exit;
        }

        // Chemin de l'image actuelle
        $currentImagePath = $existingBook->getImagePath();

        // Gestion de l'image
        if (isset($_FILES['updateBookImage']) && $_FILES['updateBookImage']['error'] === UPLOAD_ERR_OK) {
            $uploadService = new Utils();

            // Téléchargement de la nouvelle image
            $newImagePath = $uploadService->handleImageUpload($_FILES['updateBookImage'], 'books', 'defaultBook.png');

            // Suppression de l'ancienne image si elle n'est pas celle par défaut
            if ($currentImagePath !== './uploads/books/defaultBook.png' && file_exists($currentImagePath)) {
                if (unlink($currentImagePath)) {
                    error_log("Ancienne image supprimée : $currentImagePath");
                } else {
                    error_log("Échec de la suppression de l'image : $currentImagePath");
                }
            }

            // Mettre à jour le chemin de l'image
            $currentImagePath = $newImagePath;
        }

        // Instanciation du livre
        $book = new Book();
        $book->setIdBook($id_book);
        $book->setTitle($title);
        $book->setAuthorName($author_name);
        $book->setDescription($description);
        $book->setIsAvailable($is_available);
        $book->setImagePath($currentImagePath);

        // Mise à jour via BookManager
        try {
            $bookManager->updateBook($book);
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



// DELETE
public function deleteBook(): void
{
    // Vérifie si un ID valide est passé dans l'URL
    if (isset($_GET['id_book']) && is_numeric($_GET['id_book'])) {
        $bookId = (int)$_GET['id_book'];

        // Instancie le BookManager
        $bookManager = new BookManager();
        $book = $bookManager->findBookById($bookId);

        if ($book) {
            // Supprime l'image si elle n'est pas celle par défaut
            if ($book->getImagePath() !== './uploads/books/defaultBook.png' && 
                file_exists($book->getImagePath())) {
                unlink($book->getImagePath());
            }

            // Supprime le livre de la base de données
            $bookManager->deleteBook($bookId);

            // Redirection après suppression
            header("Location: index.php?action=myAccount&message=deleted");
            exit;
        } else {
            // Si le livre n'existe pas
            echo "Erreur : Livre introuvable.";
        }
    } else {
        // Si l'ID est manquant ou invalide, redirige vers la page "Mon compte"
        header("Location: index.php?action=myAccount");
        exit;
    }
}



    
}
