<!-- Première section : Présentation et appel à l'action -->
<div class="firstSection">
    <section class="homeFirstSection">
        <article>
            <h1>Rejoignez nos lecteurs passionnés</h1>
            <p>
                Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux 
                de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
            </p>
            <button class="button">
                <a href="index.php?action=availableBooks">Découvrir</a>
            </button>
        </article>
        <aside>
            <img src="images/homeFirstImg.jpg" alt="Image d'accueil">
            <figcaption>Hamza</figcaption>
        </aside>
    </section>
</div>

<!-- Deuxième section : Affichage des derniers livres ajoutés -->
<div class="secondSection">
    <section class="homeSecondSection">
        <h1>Les derniers livres ajoutés</h1>
        <div class="imgGroupBlocks">
            <?php if (!empty($lastBooks)): ?>
                <?php foreach ($lastBooks as $book): ?>
                    <div class="imgBlock">
                        <!-- Affichage de l'image du livre -->
                        <img src="<?= htmlspecialchars($book->getImagePath()) ?>" alt="<?= htmlspecialchars($book->getTitle()) ?>">
                        <div class="imgBlockText">
                            <!-- Titre du livre -->
                            <h2 class="titleHome"><?= htmlspecialchars($book->getTitle()) ?></h2>
                            <!-- Auteur du livre -->
                            <p><?= htmlspecialchars($book->getAuthorName()) ?></p>
                            <!-- Nom du propriétaire -->
                            <p class="pSoldBy">Vendu par : <?= htmlspecialchars($book->getOwnerName()) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun livre ajouté récemment.</p>
            <?php endif; ?>
        </div>
        <button class="button seeAllBooks">
            <a href="index.php?action=availableBooks">Voir tous les livres</a>
        </button>
    </section>
</div>

<!-- Troisième section : Explication du fonctionnement de la plateforme -->
<div class="thirdSection">
    <section class="homeThirdSection">
        <h1>Comment ça marche ?</h1>
        <p id="ptitle">
            Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :
        </p>
        <div class="textGroupBlocks">
            <div class="textBlock">
                <p>Inscrivez-vous gratuitement sur <br>notre plateforme.</p>
            </div>
            <div class="textBlock">
                <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
            </div>
            <div class="textBlock">
                <p>Parcourez les livres disponibles chez d'autres membres.</p>
            </div>
            <div class="textBlock">
                <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
            </div>
        </div>
        <button class="button seeAllBooksTransparent">
            <a href="index.php?action=availableBooks">Voir tous les livres</a>
        </button>
    </section>
</div>

<!-- Quatrième section : Image décorative -->
<div class="fourthSection">
    <img src="images/maskGroup.jpg" alt="image décorative bibliothèque">
</div>

<!-- Cinquième section : Présentation des valeurs de Tom Troc -->
<div class="fifthSection">
    <section class="homeFifthSection">
        <h1>Nos valeurs</h1>
        <p>
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté.
            Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer
            des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler
            les gens et inspirer des conversations enrichissantes.
        </p>
        <p>
            Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.
        </p>
        <p>
            Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter,
            de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
        </p>
        <div class="signature">
            <p>
                <span>L'équipe Tom Troc</span>
            </p>
            <img id="heart" src="images/heart.png" alt="Coeur décoratif">
        </div>
    </section>
</div>
