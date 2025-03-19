<section class="addEditBookProfileForm">
    <!-- Lien de retour vers "Mon compte" -->
    <p class="pBackAdd">
        <a href="index.php?action=myAccount">
            <img class="arrow pBack" src="./images/arrow.png" alt="Retour">retour
        </a>
    </p>

    <!-- Titre de la page -->
    <h1>Modifier les informations</h1>

    <div class="addEditBookContainer">
        <!-- Bloc gauche : prévisualisation de l'image du livre -->
        <div class="leftBlock">
            <p>Photo</p>
            <div>
                <!-- Affichage de l'image actuelle du livre ou de l'image par défaut si le chemin est vide ou invalide -->
                <img class="previewImage"
                     id="updateBookImagePreview"
                     src="<?= !empty($book->getImagePath()) && file_exists($book->getImagePath()) ? htmlspecialchars($book->getImagePath()) : './uploads/books/defaultBook.png' ?>" 
                     alt="Image de couverture">
            </div>
            <p>
                <!-- Lien qui déclenche l'ouverture du sélecteur de fichier pour modifier l'image -->
                <a href="javascript:void(0);" id="addImageLink">Modifier une photo</a>
            </p>
        </div>

        <!-- Formulaire de modification des informations du livre -->
        <form method="POST" action="index.php?action=updateBook" enctype="multipart/form-data">
            <!-- Champ caché pour l'upload de l'image -->
            <input type="file" id="updateBookImage" aria-label="updateBookImage" name="updateBookImage" style="display: none;" accept="image/*">
            <!-- Champ caché pour transmettre l'identifiant du livre -->
            <input type="hidden" name="id_book" value="<?= htmlspecialchars($book->getIdBook()) ?>">

            <!-- Champ pour modifier le titre -->
            <div class="formInput">
                <label for="getBookTitle">Titre</label>
                <input type="text" id="getBookTitle" name="getBookTitle" 
                       value="<?= htmlspecialchars($book->getTitle()) ?>">
            </div>

            <!-- Champ pour modifier l'auteur -->
            <div class="formInput">
                <label for="getBookAuthor">Auteur</label>
                <input type="text" id="getBookAuthor" name="getBookAuthor" 
                       value="<?= htmlspecialchars($book->getAuthorName()) ?>">
            </div>

            <!-- Champ pour modifier la description / commentaire -->
            <div class="formInput formInputDescription">
                <label for="getBookDescription">Commentaire</label>
                <textarea id="getBookDescription" name="getBookDescription"><?= htmlspecialchars($book->getDescription()) ?></textarea>
            </div>

            <!-- Sélecteur de disponibilité du livre -->
            <div class="formInput">
                <label for="getBookIsAvailable">Disponibilité</label>
                <select id="getBookIsAvailable" name="getBookIsAvailable">
                    <option value="1" <?= $book->getIsAvailable() ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= !$book->getIsAvailable() ? 'selected' : '' ?>>Non disponible</option>
                </select>
            </div>

            <!-- Bouton de validation du formulaire -->
            <button class="button subscribe" type="submit">Valider</button>
        </form>
    </div>
</section>

<!-- JavaScript pour gérer l'upload d'image et la prévisualisation -->
<script>
    // Lorsqu'on clique sur le lien "Modifier une photo", ouvre le sélecteur de fichier caché
    document.getElementById('addImageLink').addEventListener('click', function() {
        document.getElementById('updateBookImage').click();
    });

    // Lorsqu'une image est sélectionnée, affiche une prévisualisation de l'image
    document.getElementById('updateBookImage').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(event) {
                // Met à jour l'image de prévisualisation avec le fichier sélectionné
                document.getElementById('updateBookImagePreview').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
