<section class="books">
    <!-- Partie supérieure : titre et barre de recherche -->
    <div class="partOne">
        <h1>Nos livres à l'échange</h1>
        <form class="exchangeBooks" action="index.php" method="GET">
            <!-- Bouton de recherche avec une icône (loupe) -->
            <button id="searchButton" type="submit">
                <img src="images/union.png" alt="Loupe recherche">
            </button>
            <!-- Champ de recherche pour saisir un livre -->
            <label for="search">
                <input type="text" id="search" name="search" placeholder="Rechercher un livre">
            </label>
            <!-- Champ caché pour préciser l'action de recherche -->
            <input type="hidden" name="action" value="searchResults">
        </form>
    </div>

    <!-- Partie inférieure : affichage des livres -->
    <div class="bookBlock">
        <?php if (!empty($books)): ?>
            <!-- Parcourt la liste des livres -->
            <?php foreach ($books as $book): ?>
                <div class="bookImgBlock">
                    <!-- Wrapper pour l'image et le tag de disponibilité -->
                    <div class="bookImageWrapper">
                        <?php if (!$book->getIsAvailable()): ?>
                            <!-- Tag indiquant que le livre n'est pas disponible -->
                            <div class="availabilityTag">Non dispo.</div>
                        <?php endif; ?>
                        <!-- Lien vers les détails du livre -->
                        <a href="index.php?action=bookDetails&id=<?= htmlspecialchars($book->getIdBook()); ?>">
                            <img src="<?= htmlspecialchars($book->getImagePath()); ?>" alt="<?= htmlspecialchars($book->getTitle()); ?>">
                        </a>
                    </div>
                    <!-- Informations textuelles du livre -->
                    <div class="bookImgBlockText">
                        <h3><?= htmlspecialchars($book->getTitle()); ?></h3>
                        <p><?= htmlspecialchars($book->getAuthorName()); ?></p>
                        <p>Vendu par : <?= htmlspecialchars($book->getOwnerName()); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Message affiché s'il n'y a aucun livre -->
            <p>Aucun livre disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</section>
