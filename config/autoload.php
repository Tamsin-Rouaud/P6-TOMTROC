<?php
/**
 * Système d'autoload pour charger automatiquement les classes nécessaires.
 *
 * Lorsque PHP a besoin d'une classe non encore incluse, la fonction de rappel
 * enregistrée ici est appelée. Elle cherche le fichier correspondant à la classe
 * dans les répertoires "services", "models", "controllers" et "views".
 * Si le fichier est trouvé, il est inclus via require_once.
 */
spl_autoload_register(function ($className) {
    // Liste des répertoires à explorer pour charger la classe
    $directories = ['services', 'models', 'controllers', 'views'];

    // Parcourt chaque dossier et inclut le fichier si il existe
    foreach ($directories as $directory) {
        $file = $directory . '/' . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            // On sort de la boucle dès que la classe est chargée pour éviter les inclusions multiples
            return;
        }
    }
});
