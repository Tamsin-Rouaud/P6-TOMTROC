<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Utilisation de la variable $title pour définir le titre de la page -->
    <title><?= htmlspecialchars($title) ?></title>

    <!-- Définir la base pour les liens relatifs -->
    <base href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] ?>/p6-tomtroc/">

    <!-- Lien fichier style général -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Lien fichier style header -->
    <link rel="stylesheet" href="css/styleHeader.css">
    <!-- Lien fichier style footer -->
    <link rel="stylesheet" href="css/styleFooter.css">
    <!-- Lien fichier style home -->
    <link rel="stylesheet" href="css/styleHomePage.css">
    <!-- Lien fichier style availableBooks -->
    <link rel="stylesheet" href="css/styleAvailableBooks.css">
    <!-- Lien fichier style styleLoginForm -->
    <link rel="stylesheet" href="css/styleLoginForm.css">
    <!-- Lien fichier style styleMyAccount -->
    <link rel="stylesheet" href="css/styleMyAccount.css">
    <!-- Lien fichier style styleAddEditBookProfileForm -->
    <link rel="stylesheet" href="css/styleAddEditBookProfileForm.css">
    <!-- Lien fichier style styleSearch -->
    <link rel="stylesheet" href="css/styleSearch.css">
    <!-- Lien fichier style styleBookDetails -->
    <link rel="stylesheet" href="css/styleBookDetails.css">
    <!-- Lien fichier style stykeProfileDetails  -->
    <link rel="stylesheet" href="css/styleProfileDetails.css" >
    <!-- Lien fichier style styleMessaging -->
    <link rel="stylesheet" href="css/styleMessaging.css" >

</head>

<body>
    <?php require 'views/partials/header.php'; ?>
    <main>
    <?= $content ?>
    </main>

    <?php require 'views/partials/footer.php'; ?>
</body>
</html>
