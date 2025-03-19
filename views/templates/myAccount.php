<?php
// Activation du mode d'affichage des erreurs pour le débogage (à désactiver en production)
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<section class="myAccount">
    <h1 id="titleMyAccount">Mon compte</h1>
    <div class="myAccountBox">
        <!-- Bloc profil : informations et photo de l'utilisateur -->
        <div class="boxProfile">
            <div class="profile">
                <div class="profileBlock">
                    <!-- Affichage de la photo de profil actuelle ou de l'image par défaut -->
                    <img class="BlockProfilePicture"
                         id="profileImagePreview"
                         src="<?= !empty($user->getImagePathUser()) && file_exists($user->getImagePathUser()) ? htmlspecialchars($user->getImagePathUser()) : './uploads/users/defaultAvatar.png' ?>"
                         alt="Photo de profil">
                    <!-- Lien permettant de modifier la photo de profil -->
                    <a href="./index.php?action=addProfilePicture">Modifier</a>
                    <!-- Champ de type file pour l'upload de la photo (inclus ici pour la prévisualisation via JS, bien que la modification se fasse sur une autre page) -->
                    <input type="file" id="addProfileImage" aria-label="addProfileImage" name="addProfileImage"  accept="image/*" style="display:none;">
                </div>
                <div class="underline"></div>
                <div class="profileText">
                    <!-- Affichage du pseudo de l'utilisateur -->
                    <h4><?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu', ENT_QUOTES, 'UTF-8'); ?></h4>
                    <!-- Affichage de la durée d'adhésion -->
                    <p id="firstP">Membre depuis <?= htmlspecialchars($membershipDuration ?? 'inconnu'); ?></p>
                    <p id="secondP">BIBLIOTHÈQUE</p>
                    <!-- Affichage du nombre de livres appartenant à l'utilisateur -->
                    <p>
                        <img class="iconBook" src="./images/bookIcon.png" alt="icône de livre">
                        <?php 
                            $bookCount = BookManager::getUserBookCount($user->getIdUser());
                            echo $bookCount . ' livre' . ($bookCount > 1 ? 's' : '');
                        ?>
                    </p>
                    <!-- Bouton pour ajouter un livre -->
                    <!-- <button class="button btnAddBook"> -->
                        <a class="buttonLink btnAddBook" href="./index.php?action=addBookForm">Ajouter un livre</a>
                    <!-- </button> -->
                </div>
            </div>
        </div>

        <!-- Bloc informations personnelles : formulaire de mise à jour -->
        <div class="boxInformationProfile">
            <form class="informationProfile" enctype="multipart/form-data" method="POST" action="index.php?action=updateUser">
                <h4>Vos informations personnelles</h4>
                <div class="formInputLogin">
                    <!-- Champ caché pour transmettre l'ID utilisateur -->
                    <input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getIdUser()) ?>">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail() ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="formInputLogin">
                    <label for="password">Mot de passe</label>
                    <!-- Le champ mot de passe est vide et affiche un placeholder -->
                    <input type="password" id="password" name="password" value="" placeholder="********">
                </div>
                <div class="formInputLogin">
                    <label for="username">Pseudo</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername() ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="buttonSave">
                    <button id="save"  type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bloc affichage des livres de l'utilisateur (version desktop) -->
    <div class="myBookBlock desktopVersion">
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
                            <?= htmlspecialchars($book->getAuthorName(), ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td class="description">
                            <!-- Utilisation d'un tooltip pour afficher la description complète -->
                            <span class="tooltip" data-tooltip="<?= htmlspecialchars($book->getDescription(), ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars(substr($book->getDescription(), 0, 87), ENT_QUOTES, 'UTF-8'); ?>...
                            </span>
                        </td>
                        <td class="available">
                            <!-- Bouton indiquant la disponibilité -->
                            <button class="<?= $book->getIsAvailable() ? 'is-available' : 'not-available'; ?>">
                                <?= $book->getIsAvailable() ? 'disponible' : 'non dispo.'; ?>
                            </button>
                        </td>
                        <td class="editDelete">
                            <!-- Lien pour éditer le livre -->
                            <a class="btnChoice btnEdit" href="index.php?action=editBook&id_book=<?= $book->getIdBook(); ?>">Éditer</a>
                            <!-- Lien pour supprimer le livre avec confirmation -->
                            <a class="btnChoice btnDelete" href="index.php?action=deleteBook&id_book=<?= $book->getIdBook(); ?>" 
                               <?= Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer ce livre ?"); ?>>
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bloc affichage des livres de l'utilisateur (version mobile) -->
    <div class="myBookBlock mobileVersion">
        <?php foreach ($books as $book): ?>
            <div class="card">
                <div class="photoTitle">
                    <div class="cardPhoto">
                        <img src="<?= htmlspecialchars($book->getImagePath(), ENT_QUOTES, 'UTF-8'); ?>" alt="Photo du livre">
                    </div>
                    <div class="cardTitle">
                        <h3><?= htmlspecialchars($book->getTitle()); ?></h3>
                        <p><?= htmlspecialchars($book->getAuthorName()); ?></p>
                        <p class="available-notAvailable">
                            <span class="<?= $book->getIsAvailable() ? 'is-available' : 'not-available'; ?>">
                                <?= $book->getIsAvailable() ? 'disponible' : 'non dispo.'; ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="cardInfo">
                    <p><?= htmlspecialchars(substr($book->getDescription(), 0, 87)); ?>...</p>
                    <div class="cardActions">
                        <a href="index.php?action=editBook&id_book=<?= $book->getIdBook(); ?>">Éditer</a>
                        <a href="index.php?action=deleteBook&id_book=<?= $book->getIdBook(); ?>"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                            Supprimer
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- JavaScript pour la prévisualisation de l'image de profil lors de l'upload -->
<script>
    document.getElementById('addProfileImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Vérifie que le fichier est une image
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner un fichier image.');
                return;
            }
            // Vérifie que la taille du fichier est inférieure à 2 Mo
            if (file.size > 2 * 1024 * 1024) {
                alert('La taille du fichier doit être inférieure à 2 Mo.');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(event) {
                // Met à jour la prévisualisation de l'image
                document.getElementById('profileImagePreview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
