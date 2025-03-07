<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le titre de la page est défini dynamiquement à partir de la variable $title -->
    <title><?= htmlspecialchars($title) ?></title>

    <!-- Définition de la base pour les liens relatifs.
         Cela permet de définir un chemin de base pour toutes les URL relatives dans la page. -->
    <base href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] ?>/p6-tomtroc/">

    <!-- Inclusion des feuilles de styles CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleHeader.css">
    <link rel="stylesheet" href="css/styleFooter.css">
    <link rel="stylesheet" href="css/styleHomePage.css">
    <link rel="stylesheet" href="css/styleAvailableBooks.css">
    <link rel="stylesheet" href="css/styleLoginForm.css">
    <link rel="stylesheet" href="css/styleMyAccount.css">
    <link rel="stylesheet" href="css/styleAddEditBookProfileForm.css">
    <link rel="stylesheet" href="css/styleSearch.css">
    <link rel="stylesheet" href="css/styleBookDetails.css">
    <link rel="stylesheet" href="css/styleProfileDetails.css">
    <link rel="stylesheet" href="css/styleMessaging.css">
    <link rel="stylesheet" href="css/styleError.css">
</head>

<body>
<?php
    // Initialisation du compteur de messages non lus à 0 par défaut
    $unreadMessagesCount = 0;

    // Si l'utilisateur est connecté (vérifié par la présence d'un ID dans la session)
    if (isset($_SESSION['user']['id'])) {
        // Inclusion du MessageManager pour pouvoir compter les messages non lus
        require_once 'models/MessageManager.php';
        $messageManager = new MessageManager();

        // Calcul du nombre de messages non lus pour l'utilisateur connecté
        $unreadMessagesCount = $messageManager->countUnreadMessages($_SESSION['user']['id']);
    }
?>

    <!-- Inclusion du header (menu de navigation, logo, etc.) -->
    <?php require 'views/partials/header.php'; ?>

    <!-- Contenu principal de la page -->
    <main>
        <?= $content ?>
    </main>

    <!-- Inclusion du footer -->
    <?php require 'views/partials/footer.php'; ?>
</body>
</html>
