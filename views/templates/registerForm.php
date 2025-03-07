<section class="connexionBlock">
    <!-- Formulaire d'inscription -->
    <form class="connexionText" method="POST" action="index.php?action=showRegisterForm">
        <!-- Titre du formulaire -->
        <h1 id="connexionTitle">Inscription</h1>
        
        <!-- Champ de saisie pour le pseudo -->
        <div class="formInputLogin">
            <label for="username">Pseudo</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <!-- Champ de saisie pour l'email -->
        <div class="formInputLogin">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        
        <!-- Champ de saisie pour le mot de passe -->
        <div class="formInputLogin">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>
        
        <!-- Bouton de soumission du formulaire -->
        <button class="button subscribe" type="submit">S'inscrire</button>
        
        <!-- Lien pour rediriger les utilisateurs déjà inscrits vers la page de connexion -->
        <p>Déjà inscrit ? <a href="index.php?action=loginForm">Connectez-vous</a></p>
    </form>

    <!-- Bloc d'image pour la page d'inscription -->
    <div class="connexionImg">
        <img src="images/imgLogin.jpg" alt="Image page d'inscription">
    </div>
</section>
