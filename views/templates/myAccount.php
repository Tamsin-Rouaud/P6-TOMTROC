

<section class="myAccount">
    <h1 id="titleMyAccount" >Mon compte</h1>
    <div class="myAccountBox">
        <div class="boxProfile">
            <div class="profile">
                <div class="profileBlock" >
                    <img src="./images/profileIcon.png" alt="Photo de profil">
                    <a href="#">modifier</a>
                </div>
                <div class="underline">

                </div>
                <div class="profileText">
                    <h4>Nathalire</h4>
                    <p id="firstP">Membre depuis 1 an</p>
                    <p id="secondP">BIBLIOTHEQUE</p>
                    <p ><img src="./images/bookIcon.png" alt="icône de livre"> 4 livres</p>
                    <button class="button btnAddBook"><a href="./index.php?action=addBookForm">Ajouter un livre</a></button>
                </div>
            </div>
        </div>
        <div class="boxInformationProfile">
            <form class="informationProfile">
                <h4>Vos informations personnelles</h4>
                <div class="formInput">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="formInput">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="formInput">
                    <label for="username">Pseudo</label>
                    <input type="text" id="username" name="username">
                </div>
                <div class="buttonSave">
                    <button class="button save" type="submit"><a href="#">Enregistrer</a></button>
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
            <?php foreach ($books as $book): ?>
                <tr>
                    <td class="photo"><img src="images/<?= $book['image_path']; ?>" alt="Photo du livre"></td>
                    <td class="title"><?= htmlspecialchars($book['title']); ?></td>
                    <td class="author"><?= htmlspecialchars($book['author_name']); ?></td>
                    <td class="description">
                        <span class="tooltip" data-tooltip="<?= htmlspecialchars($book['description']); ?>">
                            <?= htmlspecialchars(substr($book['description'], 0, 87)); ?>...
                        </span>
                    </td>

                    <td class="available">
                        <button class="<?= $book['is_available'] ? 'available' : 'not-available'; ?>">
                            <?= $book['is_available'] ? 'disponible' : 'non dispo.'; ?>
                        </button>
                    </td>
                    <td class="editDelete">
                        <a href="index.php?action=editBookForm&id_books=<?= $book['id_books'] ?>">
                            <button class="btnChoice btnEdit">Éditer</button>
                        </a>
                        <button class="btnChoice btnDelete">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="buttonAllBooks">
        <a href="index.php?action=showAllBooks" class="button">Afficher tous les livres</a>
    </div>
</div>


</section>