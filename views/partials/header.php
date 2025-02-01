<?php
function is_active($page) {
    return basename($_SERVER['REQUEST_URI']) === $page ? 'active' : '';
}

// Vérification si l'utilisateur est connecté
$is_user_logged_in = isset($_SESSION['user']);

?>

<header>
    <nav>
        <ul>
            <div class="firstPart">
                <li><a href="index.php"><img id="logo" src="images/logo.png" alt="Logo TomTroc"></a></li>
                <li><a class="<?= is_active('index.php') ?>" href="./index.php">Accueil</a></li>
                <li><a class="<?= is_active('index.php?action=availableBooks') ?>" href="./index.php?action=availableBooks">Nos livres à l'échange</a></li>
            </div>
            <div class="secondPart">
            <li>
    <a class="<?= is_active('index.php?action=messaging') ?>" href="index.php?action=messaging">
        <img class="icon" src="images/iconMail.png" alt="Ma messagerie">
        Messagerie
        <?php if ($unreadMessagesCount > 0): ?>
            <span><?= $unreadMessagesCount ?></span>
        <?php endif; ?>
    </a>
</li>


                <?php if ($is_user_logged_in): ?>
                    <!-- Si l'utilisateur est connecté, afficher "Mon compte" et "Déconnexion" -->
                    <li><a class="<?= is_active('index.php?action=myAccount') ?>" href="./index.php?action=myAccount"><img class="icon" src="images/iconAccount.png" alt="Mon compte">Mon compte</a></li>
                    <li><a href="index.php?action=logout">Déconnexion</a></li>
                <?php else: ?>
                    <!-- Si l'utilisateur n'est pas connecté, afficher "Connexion" -->
                    <li><a class="<?= is_active('index.php?action=loginForm') ?>" href="./index.php?action=loginForm">Connexion</a></li>
                <?php endif; ?>
            </div>
        </ul>
    </nav>
</header>
