<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<section class="myAccount">
    <h1 id="titleMyAccount" >Mon compte</h1>
    <div class="myAccountBox">
        <div class="boxProfile">
            <div class="profile">
                <div class="profileBlock" >
                    <img 
                        class="BlockProfilePicture"
                        id="profileImagePreview"                    
                        src="<?= !empty($user->getImagePathUser()) && file_exists($user->getImagePathUser()) ? htmlspecialchars($user->getImagePathUser()) : './uploads/users/defaultAvatar.png' ?> "
                        alt="Photo de profil"
                        >
                        <!-- Lien pour ouvrir le sélecteur de fichier -->
               
                <a href="./index.php?action=addProfilePicture">Modifier</a>
                </p>

 
                    <input type="file" id="addProfileImage" name="addProfileImage" enctype="multipart/form-data" accept="image/*" style="display:none;">

                </div>
                <div class="underline">

                </div>
                <div class="profileText">
                    <!-- debogage -->
               
                    <h4><?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu', ENT_QUOTES, 'UTF-8'); ?></h4>
                    <p id="firstP">Membre depuis <?= htmlspecialchars($membershipDuration ?? 'inconnu'); ?></p>
                    <p id="secondP">BIBLIOTHEQUE</p>
                    <p ><img class="iconBook" src="./images/bookIcon.png" alt="icône de livre"><?php 
                        $bookCount = BookManager::getUserBookCount($user->getIdUser());
                        echo $bookCount . ' livre' . ($bookCount > 1 ? 's' : ''); 
                        ?></p>
                    <button class="button btnAddBook"><a href="./index.php?action=addBookForm">Ajouter un livre</a></button>
                </div>
            </div>
        </div>

        <div class="boxInformationProfile">
            <form class="informationProfile" method="POST" action="index.php?action=updateUser">
                <h4>Vos informations personnelles</h4>
                <div class="formInputLogin">
                <input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getIdUser()) ?>">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail() ?? '', ENT_QUOTES, 'UTF-8'); ?>" >
                </div>
                <div class="formInputLogin">
                    <label for="password">Mot de passe</label>


<input type="password" id="password" name="password" value="" placeholder="********"  >


                </div>
                <div class="formInputLogin">
                    <label for="username">Pseudo</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername() ?? '', ENT_QUOTES, 'UTF-8'); ?>" >
                </div>
                <div class="buttonSave">
                    <button class="button save" type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    





    <div class="myBookBlock desktop-version">
  <!-- Ton <table> classique -->
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
            <td class="photo">
                <img src="<?= htmlspecialchars($book->getImagePath(), ENT_QUOTES, 'UTF-8'); ?>" alt="Photo du livre">
            </td>
            <td class="title">
                <?= htmlspecialchars($book->getTitle(), ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="author">
                <?=htmlspecialchars($book->getAuthorName(), ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="description">
                <span class="tooltip" data-tooltip="<?= htmlspecialchars($book->getDescription(), ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars(substr($book->getDescription(), 0, 87), ENT_QUOTES, 'UTF-8'); ?>...
                </span>
            </td>
            <td class="available">
                <button class="<?= $book->getIsAvailable() ? 'is-available' : 'not-available'; ?>">
                    <?= $book->getIsAvailable() ? 'disponible' : 'non dispo.'; ?>
                </button>
            </td>
            <td class="editDelete">
            
            <a class="btnChoice btnEdit" href="index.php?action=editBook&id_book=<?= $book->getIdBook(); ?>">Éditer</a>
    
            <form method="POST" action="index.php?action=deleteBook" style="display:inline;">
    <input type="hidden" name="id_book" value="<?= $book->getIdBook(); ?>">
    <!-- <button type="submit" class="btnChoice btnDelete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
        Supprimer
    </button> -->
     <a class="btnChoice btnDelete" href="index.php?action=deleteBook&id_book=<?php echo $book->getIdBook(); ?>" 
   <?php echo Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer ce livre ?"); ?>>
   Supprimer
</a>

</form> 


            
                 
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>
</div>

<div class="myBookBlock mobile-version">
  <?php foreach ($books as $book): ?>
  <div class="card">
    <div class="photo-title">
    <div class="card-photo">
      <img src="<?= htmlspecialchars($book->getImagePath(), ENT_QUOTES, 'UTF-8'); ?>" alt="Photo du livre">
    </div>
    <div class="card-title">
        <h3><?= htmlspecialchars($book->getTitle()); ?></h3>
        <p><?= htmlspecialchars($book->getAuthorName()); ?></p>
        <p class="available-notAvailable">
        <span class="<?= $book->getIsAvailable() ? 'is-available' : 'not-available'; ?>">
          <?= $book->getIsAvailable() ? 'disponible' : 'non dispo.'; ?>
        </span>
      </p>
    </div>
    </div>
    
    <div class="card-info">
      
      <p><?= htmlspecialchars(substr($book->getDescription(), 0, 87)); ?>...</p>
      
      <div class="card-actions">
        <a href="index.php?action=editBook&id_book=<?= $book->getIdBook(); ?>">Éditer</a>
        <a href="index.php?action=deleteBook&id_book=<?= $book->getIdBook(); ?>"
           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

















   


</section>
<!-- JavaScript pour gérer l'upload d'image et la prévisualisation -->
<script>
    document.getElementById('addProfileImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        if (!file.type.startsWith('image/')) {
            alert('Veuillez sélectionner un fichier image.');
            return;
        }
        if (file.size > 2 * 1024 * 1024) { // Limite de 2 Mo
            alert('La taille du fichier doit être inférieure à 2 Mo.');
            return;
        }
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('profileImagePreview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

</script>