<section class="addEditBookForm">
    <p><a href="index.php?action=myAccount"><img class="arrow" src="./images/arrow.png" alt="Retour">retour</a></p>
    <h1>Ajouter un livre</h1>
    <div class="addEditBookContainer">
        <div class="leftBlock">
            <p>Photo</p>
            <div>
                <!-- Affichage de l'image de couverture par défaut ou celle téléchargée -->
                <img id="bookImagePreview" 
                     src="./uploads/books/defaultBook.png" 
                     alt="Image de couverture" 
                     class="previewImage">
            </div>
            <p>
                <!-- Lien pour ouvrir le sélecteur de fichier -->
                <a href="javascript:void(0);" id="insertPhotoLink">Insérer une photo</a>
            </p>
        </div>

        <form method="POST" enctype="multipart/form-data" action="./index.php?action=addBook">
            <input type="file" id="addBookImage" name="addBookImage" style="display: none;" accept="image/*">

            <div class="formInput">
                <label for="addBookTitle">Titre</label>
                <input type="text" id="addBookTitle" name="addBookTitle" 
                       value="<?php echo isset($_POST['addBookTitle']) ? htmlspecialchars($_POST['addBookTitle']) : ''; ?>" 
                       required>
            </div>
            <div class="formInput">
                <label for="addBookAuthor">Auteur</label>
                <input type="text" id="addBookAuthor" name="addBookAuthor" 
                       value="<?php echo isset($_POST['addBookAuthor']) ? htmlspecialchars($_POST['addBookAuthor']) : ''; ?>" 
                       required>
            </div>
            <div class="formInput">
                <label for="addBookDescription">Commentaire</label>
                <textarea id="addBookDescription" name="addBookDescription" required><?php echo isset($_POST['addBookDescription']) ? htmlspecialchars($_POST['addBookDescription']) : ''; ?></textarea>
            </div>
            <div class="formInput">
                <label for="addBookIsAvailable">Disponibilité</label>
                <select id="addBookIsAvailable" name="addBookIsAvailable" required>
                    <option value="1" <?php echo (isset($_POST['addBookIsAvailable']) && $_POST['addBookIsAvailable'] == 1) ? 'selected' : ''; ?>>Disponible</option>
                    <option value="0" <?php echo (isset($_POST['addBookIsAvailable']) && $_POST['addBookIsAvailable'] == 0) ? 'selected' : ''; ?>>Non disponible</option>
                </select>
            </div>
            <button class="button subscribe" type="submit">Valider</button>
        </form>
    </div>
</section>

<!-- JavaScript pour gérer l'upload d'image et la prévisualisation -->
<script>
    // Lorsque l'utilisateur clique sur "Insérer une photo", ouvrir le sélecteur de fichier
    document.getElementById('insertPhotoLink').addEventListener('click', function() {
        document.getElementById('addBookImage').click();
    });

    // Lorsque l'utilisateur sélectionne une image, prévisualiser l'image sélectionnée
    document.getElementById('addBookImage').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(event) {
                // Mettre à jour l'image de prévisualisation avec le fichier sélectionné
                document.getElementById('bookImagePreview').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
