<section class="errorPage">
    <!-- Titre indiquant le code d'erreur -->
    <h1>404</h1>
    <div class="errorBlock">
        <!-- Message d'erreur générique -->
        <p>Ooops ! Cette page est introuvable.</p>
        <div class="error">
            <!-- Affichage d'une image illustrative pour l'erreur 404 -->
            <img src="./images/monsterError.png" alt="Erreur 404">
        </div>
        <!-- Affichage d'un message d'erreur personnalisé passé à la vue -->
        <p><?= htmlspecialchars($message) ?></p>
    </div>
</section>
