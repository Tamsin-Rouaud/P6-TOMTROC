<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Utilisation de la variable $title pour définir le titre de la page -->
    <title><?= htmlspecialchars($title) ?></title>
    
    <!-- Lien fichier style général -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Lien fichier style header -->
    <link rel="stylesheet" href="./css/styleHeader.css">
    <!-- Lien fichier style footer -->
    <link rel="stylesheet" href="./css/styleFooter.css">
    <!-- Lien fichier style home -->
    <link rel="stylesheet" href="./css/styleHomePage.css">
    <!-- Lien fichier style availableBooks -->
    <link rel="stylesheet" href="./css/styleAvailableBooks.css">
    <!-- Lien fichier style styleLoginForm -->
    <link rel="stylesheet" href="./css/styleLoginForm.css">


</head>

<body>
    <?php require 'views/partials/header.php'; ?>
    <main>
    <?= $content ?>
</main>

    <?php require 'views/partials/footer.php'; ?>
</body>
</html>
