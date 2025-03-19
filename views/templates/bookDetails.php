<section class="bookDetails">
    <!-- Bloc d'affichage de l'image du livre -->
    <div class="pictureBook">
        <div class="bookImageWrapper">
            <?php if (!$book->getIsAvailable()): ?>
                <!-- Si le livre n'est pas disponible, affiche un tag indiquant "non dispo." -->
                <div class="availabilityTag">non dispo.</div>
            <?php endif; ?>
            <!-- Affiche l'image de couverture du livre avec le titre utilisé comme texte alternatif -->
            <img src="<?= htmlspecialchars($book->getImagePath()) ?>" alt="<?= htmlspecialchars($book->getTitle()) ?>">
        </div>
    </div>

    <!-- Bloc d'affichage des informations textuelles du livre -->
    <div class="aboutBook">
        <!-- Titre du livre -->
        <h3 class="titleBook"><?= htmlspecialchars($book->getTitle()) ?></h3>
        <!-- Auteur du livre -->
        <p class="authorTitle">par <?= htmlspecialchars($book->getAuthorName()) ?></p>
        <div class="underlineAuthor"></div>

        <!-- Section Description -->
        <h4 class="smallTitles">DESCRIPTION</h4>
        <p class="pDescription"><?= htmlspecialchars($book->getDescription()) ?></p>

        <!-- Section Propriétaire -->
        <h4 class="smallTitles">PROPRIÉTAIRE</h4>
        <div class="profileDetails">
            <!-- Lien vers la page de profil du propriétaire -->
            <a href="index.php?action=profileDetails&id=<?= htmlspecialchars($user->getIdUser()) ?>">
                <!-- Affichage de l'image de profil du propriétaire -->
                <img src="<?= htmlspecialchars($user->getImagePathUser()) ?>" alt="Photo de profil de <?= htmlspecialchars($user->getUsername()) ?>">
                <!-- Affichage du nom d'utilisateur -->
                <p><?= htmlspecialchars($user->getUsername()) ?></p>
            </a>
        </div>
        <!-- Bouton permettant d'envoyer un message au propriétaire -->
         <!-- Bouton permettant d'envoyer un message au propriétaire -->
<a class="buttonLink subscribe" href="index.php?action=messaging&contact_id=<?= htmlspecialchars($user->getIdUser()) ?>">
    Envoyer un message
</a>

        
    </div>
</section>
