<?php

class AvailableBooksController {
    // Cette méthode est utilisée pour afficher les livres disponibles.
    public function showAvailableBooks()
    { 
    // On crée une instance du gestionnaire de livres (AvailableBooksManager) 
    // pour interagir avec les données relatives aux livres.      
    $availableBooksManager = new AvailableBooksManager();
    // Ici, on appelle la méthode `getAvailableBooksMessage` de l'instance 
    // du gestionnaire pour récupérer un message à afficher.
    // Cette méthode renvoie une chaîne de caractères, par exemple, un titre ou une info 
    // sur les livres disponibles. 
    // Le résultat est stocké dans la variable `$message`.
    $message = $availableBooksManager->getAvailableBooksMessage();
    // On crée une nouvelle instance de la classe `View`.
    // Le premier argument ('Nos livres à l\'échange') correspond au titre de la page 
    // qui sera affiché dans la balise `<title>` du fichier de la vue (head).
    // C'est le titre qui apparaît dans l'onglet du navigateur.
     
    $view = new View('Nos livres à l\'échange');
    // Ensuite, on appelle la méthode `render` de l'objet `View` pour afficher la vue.
    // Le premier argument ('availableBooks') est le nom du fichier de vue à afficher,
    // qui se trouve dans le dossier `views/templates`. Ce fichier s'appelle donc `availableBooks.php`.
    // Le deuxième argument est un tableau associatif qui contient les données à passer à la vue.
    // Ici, on passe la variable `$message` à la vue sous le nom `author`. 
    // Cela signifie qu'à l'intérieur du fichier de vue (`availableBooks.php`), 
    // on pourra utiliser `<?php echo $author  pour afficher la valeur de `$message`.
        $view->render('availableBooks',['author' => $message]);
    
}
}