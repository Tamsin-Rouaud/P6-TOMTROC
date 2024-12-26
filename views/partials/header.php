<?php
function is_active($page) {
    return basename($_SERVER['REQUEST_URI']) === $page ? 'active' : '';
}
?>


<header>
    <nav>
        <ul>
            <div class="firstPart">
                <li><a  href="index.php"><img id="logo" src="images/logo.png" alt="Logo TomTroc"></a></li>
                <li><a class="<?= is_active('index.php') ?>" href="./index.php">Accueil</a></li>
                <li><a class="<?= is_active('index.php?action=availableBooks') ?>" href="./index.php?action=availableBooks">Nos livres à l'échange</a></li>
            </div>
            <div class="secondPart">
                <li><a class="<?= is_active('index.php') ?>" href="./index.php"><img class="icon" src="images/iconMail.png" alt="Ma messagerie">Messagerie  <span>1</span></a></li>
                <li><a class="<?= is_active('index.php') ?>" href="./index.php"><img class="icon" src="images/iconAccount.png" alt="Mon compte"> Mon compte</a></li>
                <li><a class="<?= is_active('index.php?action=loginForm') ?>" href="./index.php?action=loginForm">Connexion</a></li>
            </div>
        </ul  >
    </nav>
</header>