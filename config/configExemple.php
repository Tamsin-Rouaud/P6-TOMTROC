<?php
/**
 * Fichier d'exemple de configuration.
 *
 * Ce fichier doit être renommé en "config.php" une fois personnalisé avec vos propres identifiants.
 * Il démarre la session et définit les constantes pour les chemins vers les templates de vues
 * ainsi que les paramètres de connexion à la base de données.
 */

// Démarrer la session utilisateur, indispensable pour la gestion des états et des connexions
session_start();

// Définition du chemin vers le dossier contenant les templates de vues
define('TEMPLATE_VIEW_PATH', './views/templates/');

// Définition du chemin complet vers le template principal (main.php)
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php');

// Informations de connexion à la base de données
// Remplacez les valeurs vides par vos propres identifiants de base de données avant de renommer ce fichier en config.php
define('DB_HOST', '');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASS', '');

