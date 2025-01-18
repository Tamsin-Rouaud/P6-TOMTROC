<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<section class="addEditBookForm">
    <p>
        <a href="index.php?action=myAccount"><img class="arrow" src="./images/arrow.png" alt="Retour">retour</a>
    </p>
    <h1>Modifier un livre</h1>
    <div class="addEditBookContainer">
        <div class="leftBlock">
            <p>Photo</p>
            <div>
                
                <!-- Affichage de l'image actuelle ou de l'image par défaut -->
                <a href="#">
                <img 
                        id="bookImagePreview" 
                        src="<?= !empty($book->getImagePath()) && file_exists($book->getImagePath()) ? htmlspecialchars($book->getImagePath()) : './uploads/books/defaultBook.png' ?>" 
                        alt="Image du livre">
                </a>
            </div>
            <p>
                <a href="#" id="addImageLink">Modifier une photo</a>
            </p>
            <!-- Input caché pour permettre le téléchargement d'une nouvelle image -->
            <input type="file" name="image" id="image" style="display: none;" onchange="previewImage(event)">
        </div>
        
        <form method="POST" action="index.php?action=editBook&id_book=<?= htmlspecialchars($book->getIdBook()) ?>" enctype="multipart/form-data">
    <input type="hidden" name="id_book" value="<?= htmlspecialchars($book->getIdBook()) ?>">
    
    <label for="getBookTitle">Titre</label>
    <input 
        type="text" 
        id="getBookTitle" 
        name="getBookTitle" 
        value="<?= htmlspecialchars($book->getTitle()) ?>" 
        required>

    <label for="getBookAuthor">Auteur</label>
    <input 
        type="text" 
        id="getBookAuthor" 
        name="getBookAuthor" 
        value="<?= htmlspecialchars($book->getAuthorName()) ?>" 
        required>

    <label for="getBookDescription">Description</label>
    <textarea 
        id="getBookDescription" 
        name="getBookDescription"><?= htmlspecialchars($book->getDescription()) ?></textarea>

    <label for="getBookIsAvailable">Disponibilité</label>
    <select id="getBookIsAvailable" name="getBookIsAvailable">
        <option value="1" <?= $book->getIsAvailable() ? 'selected' : '' ?>>Disponible</option>
        <option value="0" <?= !$book->getIsAvailable() ? 'selected' : '' ?>>Non disponible</option>
    </select>

    <label for="image">Image</label>
    <input type="file" name="image" id="image">

    <button type="submit">Modifier</button>
</form>

    </div>
</section>
<script>
    // Récupérer le lien et l'input de fichier
    const addImageLink = document.getElementById('addImageLink');
    const fileInput = document.getElementById('image');
    
    // Lorsque l'utilisateur clique sur le lien, on ouvre la boîte de dialogue de téléchargement
    addImageLink.addEventListener('click', function(event) {
        event.preventDefault();  // Empêche le comportement par défaut du lien
        fileInput.click();  // Déclenche l'ouverture de la boîte de dialogue de téléchargement
    });
    
    // Lorsqu'un fichier est sélectionné, on affiche un aperçu de l'image
    function previewImage(event) {
    const file = event.target.files[0];  // Récupérer le fichier sélectionné
    const imagePreview = document.getElementById('bookImagePreview');

    // Vérifiez si un fichier a été sélectionné
    if (file) {
        // Vérifiez que c'est une image
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!validImageTypes.includes(file.type)) {
            alert("Veuillez sélectionner un fichier image valide (JPEG, PNG ou GIF).");
            return;
        }

        // Lire le fichier et afficher un aperçu
        const reader = new FileReader();
        reader.onload = function () {
            imagePreview.src = reader.result;  // Afficher l'image sélectionnée
        };
        reader.readAsDataURL(file);  // Lire le fichier comme URL de données
    }
}

</script>


