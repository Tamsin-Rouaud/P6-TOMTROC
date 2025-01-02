
<section class="addEditBookForm">
<p><a href="index.php?action=myAccount"><img class ="arrow" src="./images/arrow.png" alt="Retour">retour</a></p>
<h1>Ajouter un livre</h1>
    <div class="addEditBookContainer">
        <div class="leftBlock">
            <p>Photo</p>
            <div>
                <a href="#"><img src="./images/addPhoto.png" alt="Insérer une photo"></a>
            </div>
            <p>
                <a href="#">Insérer une photo</a>
            </p>
        </div>
        
        
        <form method="POST" action="./index.php?action=addBook">
            <div class="formInput">
                    <label for="addBookTitle">Titre</label>
                    <input type="text" id="addBookTitle" name="addBookTitle" required>
                </div>
                <div class="formInput">
                    <label for="addBookAuthor">Auteur</label>
                    <input type="text" id="addBookAuthor" name="addBookAuthor" required>
                </div>
                <div class="formInput">
                    <label for="addBookDescription">Commentaire</label>
                    <textarea type="text" id="addBookDescription" name="addBookDescription" required></textarea>
                </div>
                <div class="formInput">
                    <label for="addBookIsAvailable">Disponibilité</label>
                        <select id="addBookIsAvailable" name="addBookIsAvailable" required>
                            <option value="1">disponible</option>
                            <option value="0">non disponible</option>
                        </select>
                </div>
                <button class="button subscribe" type="submit">Valider</button>

        </form>
    </div>
</section>
