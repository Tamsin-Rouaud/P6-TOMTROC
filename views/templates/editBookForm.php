<section class="addEditBookForm">
<p><a href="index.php?action=myAccount"><img class ="arrow" src="./images/arrow.png" alt="Retour">retour</a></p>
    <h1>Modifier un livre</h1>
    <div class="addEditBookContainer">
        <div class="leftBlock">
            <p>Photo</p>
            <div>
                <a href="#"><img src="./images/kinfolkTable.jpg" alt="The Kinfolk Table"></a>
            </div>
            <p>
                <a href="#">Ajouter une photo</a>
            </p>
        </div>
        
        
        <form method="POST" action="./index.php?action=editBook&id_books=<?= htmlspecialchars($book['id_books']) ?>">

            <div class="formInput">
                    <label for="getBookTitle">Titre</label>
                    <input type="text" id="getBookTitle" name="getBookTitle" value="<?= htmlspecialchars($book['title']) ?>" required>
                </div>
                <div class="formInput">
                    <label for="getBookAuthor">Auteur</label>
                    <input type="text" id="getBookAuthor" name="getBookAuthor" value="<?= htmlspecialchars($book['author_name']) ?>" required>
                </div>
                <div class="formInput">
                    <label for="getBookDescription">Commentaire</label>
                    <textarea id="getBookDescription" name="getBookDescription" rows="4"><?= htmlspecialchars($book['description']) ?></textarea>
                </div>
                <div class="formInput">
                    <label for="getBookIsAvailable">Disponibilité</label>
                    <select id="getBookIsAvailable" name="getBookIsAvailable">
                <option value="1" <?= $book['is_available'] == 1 ? 'selected' : '' ?>>Disponible</option>
                <option value="0" <?= $book['is_available'] == 0 ? 'selected' : '' ?>>Non disponible</option>
            </select>
                </div>
                <button class="button subscribe" type="submit">Valider</button>

        </form>
    </div>
</section>














