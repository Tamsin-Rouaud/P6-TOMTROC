<section class="myAccount">
    <h1 id="titleMyAccount">Mon compte</h1>
    <div class="myAccountBox">
        <div class="boxProfile">
            <div class="profile">
                <div class="profileBlock">
                    <!-- Gestion de l'image de profil -->
                    <img 
                        src="<?= htmlspecialchars($user->getImagePath() ?? './uploads/users/defaultAvatar.png', ENT_QUOTES, 'UTF-8'); ?>" 
                        alt="Photo de profil" />

                    <a href="javascript:void(0);" id="insertProfilePicture">modifier</a>
                    <input type="file" id="addProfileImage" name="addProfileImage" enctype="multipart/form-data" accept="image/*" style="display:none;">
                </div>
                <div class="underline"></div>
                <div class="profileText">
                    <h4><?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu', ENT_QUOTES, 'UTF-8'); ?></h4>

                    <p id="firstP">Membre depuis <?= htmlspecialchars($user->getMembershipDuration() ?? 'inconnu'); ?></p>

                    <p id="secondP">BIBLIOTHÈQUE</p>
                    <p>
                        <img src="./images/bookIcon.png" alt="icône de livre">
                        <?php 
                        $bookCount = BookManager::getUserBookCount($user->getIdUser());
                        echo $bookCount . ' livre' . ($bookCount > 1 ? 's' : ''); 
                        ?>
                    </p>

                    <button class="button btnAddBook">
                        <a href="./index.php?action=addBookForm">Ajouter un livre</a>
                    </button>
                </div>
            </div>
        </div>

        <div class="boxInformationProfile">
            <form class="informationProfile" method="POST" action="index.php?action=updateProfile">
                <h4>Vos informations personnelles</h4>
                <div class="formInput">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail() ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="formInput">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" value="<?= htmlspecialchars($user->getPassword() ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="formInput">
                    <label for="username">Pseudo:</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername() ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="buttonSave">
                    <button class="button save" type="submit">Enregistrer</button>
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
                <?php if (!empty($books)): ?>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td class="photo">
                                <img src="<?= htmlspecialchars($book->getImagePath() ?? './uploads/books/defaultBook.png', ENT_QUOTES, 'UTF-8'); ?>" alt="Photo du livre">
                            </td>
                            <td class="title"><?= htmlspecialchars($book->getTitle() ?? 'Titre inconnu', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="author"><?= htmlspecialchars($book->getAuthorName() ?? 'Auteur inconnu', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="description">
                                <span class="tooltip" data-tooltip="<?= htmlspecialchars($book->getDescription() ?? 'Pas de description disponible.', ENT_QUOTES, 'UTF-8'); ?>">
                                    <?= htmlspecialchars(mb_substr($book->getDescription() ?? '', 0, 87), ENT_QUOTES, 'UTF-8'); ?>...
                                </span>
                            </td>
                            <td class="available">
                                <button class="<?= $book->getIsAvailable() ? 'available' : 'not-available'; ?>">
                                    <?= $book->getIsAvailable() ? 'disponible' : 'non dispo.'; ?>
                                </button>
                            </td>
                            <td class="editDelete">
                                <a href="index.php?action=editBook&id_book=<?= $book->getIdBook(); ?>" class="btnChoice btnEdit">Éditer</a>
                                <a href="index.php?action=deleteBook&id_book=<?= $book->getIdBook() ?>"
   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
   Supprimer
</a>
<!-- <button class="btnChoice btnDelete">Supprimer</button> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Aucun livre ajouté pour le moment.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
