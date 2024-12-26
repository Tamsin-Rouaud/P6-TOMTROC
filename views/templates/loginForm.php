<section class="connexionBlock">
    
        <form class="connexionText" method="post" action="" >
            <h1 id="connexionTitle">Connexion</h1>
            <div class="formInput">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="formInput">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>    
            <button class="button subscribe" type="submit">Se connecter</button>
            <p>Pas de compte ? <a href="index.php?action=registerForm">Inscrivez-vous</a></p>
        </form>
    
    <div class="connexionImg">
        <img src="images/imgLogin.jpg" alt="Image page de connexion">
    </div>
</section>
<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
