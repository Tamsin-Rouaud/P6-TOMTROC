<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Utilisation de la variable $title pour définir le titre de la page -->
    <title><?= htmlspecialchars($title) ?></title>
    
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php require 'views/partials/header.php'; ?>
    <main>
    <?= $content ?>
</main>

    <?php require 'views/partials/footer.php'; ?>
</body>
</html>
