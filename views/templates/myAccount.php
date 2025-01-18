<section class="myAccount">
    <h1 id="titleMyAccount" >Mon compte</h1>
    <div class="myAccountBox">
        <div class="boxProfile">
            <div class="profile">
                <div class="profileBlock" >
                    <img src="./images/profileIcon.png" alt="Photo de profil">
                    <a href="javascript:void(0);" id="insertProfilePicture">modifier</a>
                    <input type="file" id="addProfileImage" name="addProfileImage" enctype="multipart/form-data" accept="image/*" style="display:none;">
                </div>
                <div class="underline">

                </div>
                <div class="profileText">
                    <!-- debogage -->
               
                    <h4><?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu', ENT_QUOTES, 'UTF-8'); ?></h4>
                    <p id="firstP">Membre depuis <?= htmlspecialchars($membershipDuration ?? 'inconnu'); ?></p>
                    <p id="secondP">BIBLIOTHEQUE</p>
                    <p ><img src="./images/bookIcon.png" alt="icône de livre"><?php 
                        $bookCount = BookManager::getUserBookCount($user->getIdUser());
                        echo $bookCount . ' livre' . ($bookCount > 1 ? 's' : ''); 
                        ?></p>
                    <button class="button btnAddBook"><a href="./index.php?action=addBookForm">Ajouter un livre</a></button>
                </div>
            </div>
        </div>

        <div class="boxInformationProfile">
            <form class="informationProfile">
                <h4>Vos informations personnelles</h4>
                <div class="formInput">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail() ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="formInput">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" value="<?= htmlspecialchars($user->getPassword() ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="formInput">
                    <label for="username">Pseudo</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername() ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="buttonSave">
                    <button class="button save" type="submit"><a href="#">Enregistrer</a></button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="myBookBlock">
    <table>
        <thead>
            <tr>
                <th class="photo">PHOTO</th>
                <th class="title">TITRE</th>
                <th class="author">AUTEUR</th>
                <th class="description">DESCRIPTION</th>
                <th class="available">DISPONIBILITÉ</th>
                <th class="editDelete">ACTION</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($books as $book): ?>
                
                <tr>
                    <td class="photo"><img src="<?= $book['image_path']; ?>" alt="Photo du livre"></td>
                    <td class="title"><?= htmlspecialchars($book->getTitle()) ?></td>
                    <td class="author"><?= htmlspecialchars($book['author_name']); ?></td>
                    <td class="description">
                        <span class="tooltip" data-tooltip="<?= htmlspecialchars($book['description']); ?>">
                            <?= htmlspecialchars(substr($book['description'], 0, 87)); ?>...
                        </span>
                    </td>

                    <td class="available">
                        <button class="<?= $book['is_available'] ? 'available' : 'not-available'; ?>">
                            <?= $book['is_available'] ? 'disponible' : 'non dispo.'; ?>
                        </button>
                    </td>
                    <td class="editDelete">
                        <a href="#">
                            <button class="btnChoice btnEdit">Éditer</button>
                        </a>
                        <button class="btnChoice btnDelete">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</div>


</section>
<!-- JavaScript pour gérer l'upload d'image et la prévisualisation -->
<script>
    // Lorsque l'utilisateur clique sur "Insérer une photo", ouvrir le sélecteur de fichier
    document.getElementById('insertProfilePicture').addEventListener('click', function() {
        document.getElementById('addProfileImage').click();
    });

    // Lorsque l'utilisateur sélectionne une image, prévisualiser l'image sélectionnée
    document.getElementById('addProfileImage').addEventListener('change', function(e) {
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