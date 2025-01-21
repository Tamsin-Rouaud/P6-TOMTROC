
<section class="addEditBookProfileForm">
    <p>
        <a href="index.php?action=myAccount"><img class="arrow" src="./images/arrow.png" alt="Retour">retour</a>
    </p>
    <h1>Modifier mon avatar</h1>
    <div class="profileContainer">
        
           
            <div class="profilePicture">
                <!-- Affichage de l'image actuelle ou de l'image par défaut -->
                <img 
                        class="previewImage"
                        id="profilePicturePreview" 
                        src="<?= !empty($user->getImagePathUser()) && file_exists($user->getImagePathUser()) ? htmlspecialchars($user->getImagePathUser()) : './uploads/users/defaultAvatar.png' ?>" 
                        alt="Image de profil">
                        <p>
                <!-- Lien pour ouvrir le sélecteur de fichier -->
                <a href="javascript:void(0);" id="addProfileLink">Sélectionner une image</a>
            </p>

            </div>
            

        <form method="POST" action="index.php?action=updateProfilePicture" enctype="multipart/form-data">
        <input type="file" id="updateProfileImage" name="updateProfileImage" style="display: none;" accept="image/*">
    <input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getIdUser()) ?>">


   
    <button class="button subscribe" type="submit">Valider</button>
</form>

    </div>
</section>
<script>
 // Lorsque l'utilisateur clique sur "Modifier une photo", ouvre le sélecteur de fichier

    document.getElementById('addProfileLink').addEventListener('click', function() {
        document.getElementById('updateProfileImage').click();
    });

     // Lorsque l'utilisateur sélectionne une image, prévisualiser l'image sélectionnée
     document.getElementById('updateProfileImage').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(event) {
                // Mettre à jour l'image de prévisualisation avec le fichier sélectionné
                document.getElementById('profilePicturePreview').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });




</script>


