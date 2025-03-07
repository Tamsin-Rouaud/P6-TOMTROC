<?php
/**
 * Vérifie si la page passée en paramètre correspond à la page actuelle.
 *
 * @param string $page Le nom du fichier de la page à vérifier.
 * @return string Renvoie "active" si la page actuelle correspond, sinon une chaîne vide.
 */
function is_active($page) {
    return basename($_SERVER['REQUEST_URI']) === $page ? 'active' : '';
}

// Vérifie si un utilisateur est connecté en vérifiant la présence de 'user' dans la session
$is_user_logged_in = isset($_SESSION['user']);
?>

<header>
    <nav>
        <!-- Logo de l'application -->
        <div class="logo">
            <a href="index.php">
                <img id="logo" src="images/logo.png" alt="Logo TomTroc">
            </a>
        </div>

        <!-- Menu burger pour mobile -->
        <div class="burger" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Liens de navigation -->
        <ul class="nav-links" id="nav-links">
            <!-- Partie gauche du menu -->
            <div class="firstPart">
                <li>
                    <a class="<?= is_active('index.php') ?>" href="./index.php">Accueil</a>
                </li>
                <li>
                    <a class="<?= is_active('index.php?action=availableBooks') ?>" href="./index.php?action=availableBooks">
                        Nos livres à l'échange
                    </a>
                </li>
            </div>

            <!-- Partie droite du menu -->
            <div class="secondPart">
                <li>
                    <a class="<?= (isset($_GET['action']) && ($_GET['action'] === 'messaging' || $_GET['action'] === 'sendMessage')) ? 'active' : '' ?>" 
                       href="index.php?action=messaging">
                        <img class="icon" src="images/iconMail.png" alt="Ma messagerie">Messagerie
                        <?php if (isset($unreadMessagesCount) && $unreadMessagesCount > 0): ?>
                            <span><?= $unreadMessagesCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php if ($is_user_logged_in): ?>
                    <!-- Affiche "Mon compte" et "Déconnexion" si l'utilisateur est connecté -->
                    <li>
                        <a class="<?= is_active('index.php?action=myAccount') ?>" href="./index.php?action=myAccount">
                            <img class="icon" src="images/iconAccount.png" alt="Mon compte">Mon compte
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=logout">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <!-- Affiche "Connexion" si l'utilisateur n'est pas connecté -->
                    <li>
                        <a class="<?= is_active('index.php?action=loginForm') ?>" href="./index.php?action=loginForm">Connexion</a>
                    </li>
                <?php endif; ?>
            </div>
        </ul>
    </nav>
</header>

<!-- Inclusion du script JavaScript pour le menu burger -->
<script src="menu.js"></script>
