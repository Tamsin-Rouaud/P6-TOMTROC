<?php

    // En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
    session_start();

    
    // Définition du chemin vers les templates de vues
    define('TEMPLATE_VIEW_PATH', './views/templates/'); // Le chemin vers les templates de vues.

    // Définition du chemin vers le template principal, ici 'main.php'
    define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php'); // Le chemin vers le template principal.

    
    // Insérer vos propres identifiants de BDD et renommer ce fichier config.php
    define('DB_HOST', '');
    define('DB_NAME', ''); 
    define('DB_USER', '');
    define('DB_PASS', '');

?>
