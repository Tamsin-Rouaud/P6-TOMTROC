<section class="connexionBlock">
    <form class="connexionText" method="POST" action="index.php?action=showRegisterForm">
        <h1 id="connexionTitle">Inscription</h1>
        <div class="formInput">
            <label for="username">Pseudo</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="formInput">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>  
        <div class="formInput">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>
        <button class="button subscribe" type="submit">S'inscrire</button>
        <p>Déjà inscrit ? <a href="index.php?action=loginForm">Connectez-vous</a></p>
    </form>

    <div class="connexionImg">
        <img src="images/imgLogin.jpg" alt="Image page d'inscription">
    </div>
</section>
