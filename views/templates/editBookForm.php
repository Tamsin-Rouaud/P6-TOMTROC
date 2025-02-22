
<section class="addEditBookProfileForm">
    <p>
        <a href="index.php?action=myAccount"><img class="arrow" src="./images/arrow.png" alt="Retour">retour</a>
    </p>
    <h1>Modifier les informations</h1>
    <div class="addEditBookContainer">
        <div class="leftBlock">
            <p>Photo</p>
            <div>
                
                <!-- Affichage de l'image actuelle ou de l'image par défaut -->
                
                <img 
                        class="previewImage"
                        id="updateBookImagePreview" 
                        src="<?= !empty($book->getImagePath()) && file_exists($book->getImagePath()) ? htmlspecialchars($book->getImagePath()) : './uploads/books/defaultBook.png' ?>" 
                        alt="Image de couverture">
                
            </div>
            <p>
                <!-- Lien pour ouvrir le sélecteur de fichier -->
                <a href="javascript:void(0);" id="addImageLink">Modifier une photo</a>
            </p>
            
        </div>
        
        <form method="POST" action="index.php?action=updateBook" enctype="multipart/form-data">
        <input type="file" id="updateBookImage" name="updateBookImage" style="display: none;" accept="image/*">
    <input type="hidden" name="id_book" value="<?= htmlspecialchars($book->getIdBook()) ?>">
    
    <div class="formInput">
    <label for="getBookTitle">Titre</label>
    <input 
        type="text" 
        id="getBookTitle" 
        name="getBookTitle" 
        value="<?= htmlspecialchars($book->getTitle()) ?>" 
        >
</div>
<div class="formInput">
    <label for="getBookAuthor">Auteur</label>
    <input 
        type="text" 
        id="getBookAuthor" 
        name="getBookAuthor" 
        value="<?= htmlspecialchars($book->getAuthorName()) ?>" 
       >
</div>
<div class="formInput formInputDescription">
    <label for="getBookDescription">Commentaire</label>
    <textarea 
        id="getBookDescription" 
        name="getBookDescription"><?= htmlspecialchars($book->getDescription()) ?></textarea>
</div>
<div class="formInput">
    <label for="getBookIsAvailable">Disponibilité</label>
    <select id="getBookIsAvailable" name="getBookIsAvailable">
        <option value="1" <?= $book->getIsAvailable() ? 'selected' : '' ?>>Disponible</option>
        <option value="0" <?= !$book->getIsAvailable() ? 'selected' : '' ?>>Non disponible</option>
    </select>
</div>
    

    <button class="button subscribe" type="submit">Valider</button>
</form>

    </div>
</section>
<script>
 // Lorsque l'utilisateur clique sur "Modifier une photo", ouvre le sélecteur de fichier

    document.getElementById('addImageLink').addEventListener('click', function() {
        document.getElementById('updateBookImage').click();
    });

     // Lorsque l'utilisateur sélectionne une image, prévisualiser l'image sélectionnée
     document.getElementById('updateBookImage').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(event) {
                // Mettre à jour l'image de prévisualisation avec le fichier sélectionné
                document.getElementById('updateBookImagePreview').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });




</script>


