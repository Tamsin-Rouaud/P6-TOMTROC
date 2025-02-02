<section class="searchResults">
    <h1>Résultats pour : "<?= htmlspecialchars($searchTerm) ?>"</h1>

    <?php if (!empty($errorMessage)): ?>
        <p><?= htmlspecialchars($errorMessage) ?></p>
    <?php else: ?>
        <div class="bookResults">
            <?php foreach ($books as $book): ?>
                <div class="bookImgBlock">
                    <a href="index.php?action=bookDetails&id=<?= htmlspecialchars($book->getIdBook()) ?>">
                        <img src="<?= htmlspecialchars($book->getImagePath()) ?>" alt="<?= htmlspecialchars($book->getTitle()) ?>">
                    </a>
                    <div class="bookImgBlockText">
                        <h3><?= htmlspecialchars($book->getTitle()) ?></h3>
                        <p><?= htmlspecialchars($book->getAuthorName()) ?></p>
                        <p>Ajouté par : <?= htmlspecialchars($book->getOwnerName()) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
