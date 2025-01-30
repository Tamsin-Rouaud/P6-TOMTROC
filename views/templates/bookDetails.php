<section class="bookDetails">
    <!-- Bloc photo -->
    <div class="pictureBook">
        <div class="bookImageWrapper">
            <?php if (!$book->getIsAvailable()): ?>
                <div class="availabilityTag">non dispo.</div>
            <?php endif; ?>
            <img src="<?= htmlspecialchars($book->getImagePath()) ?>" alt="<?= htmlspecialchars($book->getTitle()) ?>">
        </div>
    </div>
    <!-- Bloc texte -->
    <div class="aboutBook">
        <h3 class="titleBook"><?= htmlspecialchars($book->getTitle()) ?></h3>
        <p class="authorTitle">par <?= htmlspecialchars($book->getAuthorName()) ?></p>
        <div class="underlineAuthor"></div>
        <h4 class="smallTitles">DESCRIPTION</h4>
        <p class="pDescription"><?= htmlspecialchars($book->getDescription()) ?></p>

        <h4 class="smallTitles">PROPRIÉTAIRE</h4>

        <div class="profileDetails">
        <a href="index.php?action=profileDetails&id=<?= htmlspecialchars($user->getIdUser()) ?>">            <img src="<?= htmlspecialchars($user->getImagePathUser()) ?>" alt="Photo de profil de <?= htmlspecialchars($user->getUsername()) ?>">
            <p><?= htmlspecialchars($user->getUsername()) ?></p>
            </a>
        </div>
                <a href="index.php?action=messaging&contact_id=<?= htmlspecialchars($user->getIdUser()) ?>">
        <button class="button subscribe" type="submit">Envoyer un message</button>
        </a>
    </div>

</section>
