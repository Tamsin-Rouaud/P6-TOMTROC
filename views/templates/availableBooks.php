
<section class="books">
    <div class="partOne">
        <h1>Nos livres à l'échange</h1>
        <form class="exchangeBooks" action="index.php" method="GET">
            <button id="searchButton" type="submit"><img src="images/union.png" alt="Loupe recherche"></button>
            <label for="search">
            <input type="text" id="search" name="search" placeholder="Rechercher un livre"></label>
            <!--Permet de définir une meilleur définition d'url avec l'input en hidden pour ne pas afficher sa value -->
            <input type="hidden" name="action" value="search">
        </form>
    </div>
    <div class="bookBlock">
        <?php foreach ($books as $book): ?>
            <div class="bookImgBlock">
                <img src="<?php echo htmlspecialchars($book->getImagePath()); ?>" alt="<?php echo htmlspecialchars($book->getTitle()); ?>">
                <div class="bookImgBlockText">
                    <h3><?php echo htmlspecialchars($book->getTitle()); ?></h3>
                    <p><?php echo htmlspecialchars($book->getAuthorName()); ?></p>
                    <p>Vendu par : <?php echo htmlspecialchars($book->getOwnerName()); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>


