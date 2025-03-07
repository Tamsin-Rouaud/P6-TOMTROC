<section class="profileDetailsBlock">
    <!-- Bloc de présentation du profil propriétaire -->
    <div class="boxProfile ownerBox">
        <div class="profileOwner">
            <div class="profileBlock">
                <!-- Affichage de la photo de profil du propriétaire ou image par défaut -->
                <img class="BlockProfilePicture"
                     id="profileImagePreview"
                     src="<?= !empty($user->getImagePathUser()) && file_exists($user->getImagePathUser()) ? htmlspecialchars($user->getImagePathUser()) : './uploads/users/defaultAvatar.png' ?>"
                     alt="Photo de profil">
                <!-- Champ caché pour l'upload d'image (non utilisé ici, mais présent pour potentielle extension) -->
                <input type="file" id="addProfileImage" name="addProfileImage" enctype="multipart/form-data" accept="image/*" style="display:none;">
            </div>
            <div class="underline"></div>
            <div class="profileText">
                <!-- Affichage du nom de l'utilisateur -->
                <h4><?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu', ENT_QUOTES, 'UTF-8'); ?></h4>
                <!-- Affichage de la durée d'adhésion -->
                <p id="firstP">Membre depuis <?= htmlspecialchars($membershipDuration ?? 'inconnu'); ?></p>
                <p id="secondP">BIBLIOTHÈQUE</p>
                <!-- Affichage du nombre de livres possédés -->
                <p>
                    <img class="iconBook" src="./images/bookIcon.png" alt="icône de livre">
                    <?php 
                        $bookCount = BookManager::getUserBookCount($user->getIdUser());
                        echo $bookCount . ' livre' . ($bookCount > 1 ? 's' : ''); 
                    ?>
                </p>
                <!-- Bouton permettant d'envoyer un message au propriétaire -->
                <button class="button writeMessage">
                    <a href="index.php?action=messaging&contact_id=<?= htmlspecialchars($user->getIdUser()) ?>">Écrire un message</a>
                </button>
            </div>
        </div>
    </div>

    <!-- Affichage des livres du propriétaire en version desktop -->
    <div class="myBookBlock ownerTable">
        <table>
            <thead>
                <tr>
                    <th class="photo">PHOTO</th>
                    <th class="title">TITRE</th>
                    <th class="author">AUTEUR</th>
                    <th class="description">DESCRIPTION</th>
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
                            <!-- Affichage avec tooltip pour la description complète -->
                            <span class="tooltip" data-tooltip="<?= htmlspecialchars($book->getDescription(), ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars(substr($book->getDescription(), 0, 87), ENT_QUOTES, 'UTF-8'); ?>...
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div><!-- /ownerTable version desktop -->

    <!-- Affichage des livres du propriétaire en version mobile sous forme de cartes -->
    <div class="myBookBlockMobile">
        <?php foreach ($books as $book): ?>
            <div class="card">
                <div class="photoTitle">
                    <div class="cardPhoto">
                        <img src="<?= htmlspecialchars($book->getImagePath(), ENT_QUOTES, 'UTF-8'); ?>" alt="Photo du livre">
                    </div>
                    <div class="cardInfo">
                        <h3><?= htmlspecialchars($book->getTitle(), ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><?= htmlspecialchars($book->getAuthorName(), ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
                <p class="descriptionMobile">
                    <?= htmlspecialchars(substr($book->getDescription(), 0, 87), ENT_QUOTES, 'UTF-8'); ?>...
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
