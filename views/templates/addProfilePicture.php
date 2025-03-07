<section class="addEditBookProfileForm">
    <!-- Lien de retour vers "Mon compte" -->
    <p>
        <a href="index.php?action=myAccount">
            <img class="arrow pBack" src="./images/arrow.png" alt="Retour">retour
        </a>
    </p>

    <!-- Titre du formulaire -->
    <h1>Modifier mon avatar</h1>

    <div class="profileContainer">
        <!-- Bloc d'affichage de l'image de profil actuelle -->
        <div class="profilePicture">
            <!-- Affiche l'image actuelle de l'utilisateur ou l'image par défaut -->
            <img class="previewImage" 
                 id="profilePicturePreview" 
                 src="<?= !empty($user->getImagePathUser()) && file_exists($user->getImagePathUser()) ? htmlspecialchars($user->getImagePathUser()) : './uploads/users/defaultAvatar.png' ?>" 
                 alt="Image de profil">
            <p>
                <!-- Lien pour ouvrir le sélecteur de fichier -->
                <a href="javascript:void(0);" id="addProfileLink">Sélectionner une image</a>
            </p>
            <!-- Formulaire de mise à jour de l'avatar -->
        <form method="POST" action="index.php?action=updateProfilePicture" enctype="multipart/form-data">
            <!-- Champ caché pour l'upload de l'image -->
            <input type="file" id="updateProfileImage" name="updateProfileImage" style="display: none;" accept="image/*">
            <!-- Transmission de l'ID utilisateur -->
            <input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getIdUser()) ?>">
            <!-- Bouton de validation -->
            <button id="butModifyPic" class="button  subscribe" type="submit">Valider</button>
        </form>
        </div>

        
    </div>
</section>

<!-- JavaScript pour gérer l'upload d'image et la prévisualisation -->
<script>
    // Ouvre le sélecteur de fichier lors du clic sur "Sélectionner une image"
    document.getElementById('addProfileLink').addEventListener('click', function() {
        document.getElementById('updateProfileImage').click();
    });

    // Lorsque l'utilisateur sélectionne une image, prévisualise l'image choisie
    document.getElementById('updateProfileImage').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(event) {
                // Met à jour la source de l'image de prévisualisation avec le contenu du fichier sélectionné
                document.getElementById('profilePicturePreview').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
