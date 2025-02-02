<section class="books">
    <div class="partOne">
        <h1>Nos livres à l'échange</h1>
        <form class="exchangeBooks" action="index.php" method="GET">
    <button id="searchButton" type="submit">
        <img src="images/union.png" alt="Loupe recherche">
    </button>
    <label for="search">
        <input type="text" id="search" name="search" placeholder="Rechercher un livre">
    </label>
    <input type="hidden" name="action" value="searchResults">
</form>


    </div>

    <div class="bookBlock">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <div class="bookImgBlock">
                    <!-- Wrapper pour gérer l'image et le tag de disponibilité -->
                    <div class="bookImageWrapper">
                        <?php if (!$book->getIsAvailable()): ?>
                            <div class="availabilityTag">Non dispo.</div>
                        <?php endif; ?>
                        <a href="index.php?action=bookDetails&id=<?= htmlspecialchars($book->getIdBook()); ?>">
                            <img src="<?= htmlspecialchars($book->getImagePath()); ?>" alt="<?= htmlspecialchars($book->getTitle()); ?>">
                        </a>
                    </div>
                    <div class="bookImgBlockText">
                        <h3><?= htmlspecialchars($book->getTitle()); ?></h3>
                        <p><?= htmlspecialchars($book->getAuthorName()); ?></p>
                        <p>Vendu par : <?= htmlspecialchars($book->getOwnerName()); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun livre disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</section>
