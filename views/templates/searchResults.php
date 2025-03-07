<section class="searchResults">
    <!-- Titre de la page affichant le terme recherché -->
    <h1>Résultats pour : "<?= htmlspecialchars($searchTerm) ?>"</h1>

    <?php if (!empty($errorMessage)): ?>
        <!-- Affiche un message d'erreur si aucun livre ne correspond à la recherche -->
        <p><?= htmlspecialchars($errorMessage) ?></p>
    <?php else: ?>
        <!-- Affichage des résultats sous forme de blocs d'images -->
        <div class="bookResults">
            <?php foreach ($books as $book): ?>
                <div class="bookImgBlock">
                    <!-- Lien vers la page de détails du livre -->
                    <a href="index.php?action=bookDetails&id=<?= htmlspecialchars($book->getIdBook()) ?>">
                        <img src="<?= htmlspecialchars($book->getImagePath()) ?>" alt="<?= htmlspecialchars($book->getTitle()) ?>">
                    </a>
                    <div class="bookImgBlockText">
                        <!-- Affichage du titre du livre -->
                        <h3><?= htmlspecialchars($book->getTitle()) ?></h3>
                        <!-- Affichage du nom de l'auteur -->
                        <p><?= htmlspecialchars($book->getAuthorName()) ?></p>
                        <!-- Affichage du propriétaire du livre -->
                        <p>Ajouté par : <?= htmlspecialchars($book->getOwnerName()) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
