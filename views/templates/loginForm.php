<section class="connexionBlock">
    <!-- Formulaire de connexion -->
    <form class="connexionText" method="post" >
        <!-- Titre du formulaire -->
        <h1 id="connexionTitle">Connexion</h1>
        <!-- Champ de saisie de l'adresse email -->
        <div class="formInputLogin">
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <!-- Champ de saisie du mot de passe -->
        <div class="formInputLogin">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </div>
        <!-- Bouton de soumission du formulaire -->
        <button class="button subscribe" type="submit">Se connecter</button>
        <!-- Lien vers le formulaire d'inscription pour les nouveaux utilisateurs -->
        <p>Pas de compte ? <a href="index.php?action=showRegisterForm">Inscrivez-vous</a></p>
    </form>

    <!-- Bloc d'image associé à la page de connexion -->
    <div class="connexionImg">
        <img src="images/imgLogin.jpg" alt="Image page de connexion">
    </div>
</section>

<!-- Affichage des erreurs éventuelles -->
<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
