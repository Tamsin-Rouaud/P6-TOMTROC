<?php
/**
 * Classe Utils
 *
 * Fournit des méthodes utilitaires pour diverses opérations courantes telles que le formatage de dates,
 * la redirection, la validation de requêtes, la gestion des uploads d'images, etc.
 */
class Utils {

    /**
     * Convertit une date en format français.
     *
     * Utilise IntlDateFormatter pour formater la date en français.
     *
     * @param DateTime $date L'objet DateTime à formater.
     * @return string La date formatée en français (ex: "lundi 1 janvier 2025").
     */
    public static function convertDateToFrenchFormat(DateTime $date): string {
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('EEEE d MMMM Y');
        return $dateFormatter->format($date);
    }

    /**
     * Redirige l'utilisateur vers une action spécifique.
     *
     * Construit une URL à partir de l'action et des paramètres fournis, puis effectue une redirection HTTP.
     *
     * @param string $action L'action à effectuer.
     * @param array $params (Optionnel) Paramètres supplémentaires à ajouter à l'URL.
     * @return void
     */
    public static function redirect(string $action, array $params = []): void {
        $url = "index.php?action=" . urlencode($action);
        foreach ($params as $paramName => $paramValue) {
            $url .= "&" . urlencode($paramName) . "=" . urlencode($paramValue);
        }
        header("Location: $url");
        exit();
    }

    /**
     * Génère un attribut HTML onclick pour demander une confirmation.
     *
     * @param string $message Le message de confirmation à afficher.
     * @return string L'attribut onclick avec la confirmation.
     */
    public static function askConfirmation(string $message): string {
        return "onclick=\"return confirm('$message');\"";
    }

    /**
     * Formate une chaîne en sécurisant son contenu et en convertissant les retours à la ligne en paragraphes HTML.
     *
     * @param string $string La chaîne à formater.
     * @param bool $convertNewLines Si vrai, convertit les retours à la ligne en balises <p>.
     * @return string La chaîne sécurisée et formatée.
     */
    public static function format(string $string, bool $convertNewLines = true): string {
        $finalString = htmlspecialchars($string, ENT_QUOTES);
        if ($convertNewLines) {
            $lines = explode("\n", $finalString);
            $finalString = "";
            foreach ($lines as $line) {
                if (trim($line) != "") {
                    $finalString .= "<p>$line</p>";
                }
            }
        }
        return $finalString;
    }

    /**
     * Récupère une variable depuis $_REQUEST ou retourne une valeur par défaut.
     *
     * @param string $variableName Le nom de la variable à récupérer.
     * @param mixed $defaultValue (Optionnel) La valeur par défaut si la variable n'existe pas.
     * @return mixed La valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null): mixed {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * Gère l'upload d'une image.
     *
     * Valide le fichier uploadé (taille, extension, MIME) et déplace l'image dans le répertoire de destination.
     * Si un chemin d'image actuel est fourni, il peut être supprimé si nécessaire.
     *
     * @param array|null $file Le fichier uploadé depuis $_FILES.
     * @param string $uploadDir Le sous-dossier dans lequel enregistrer l'image.
     * @param string $defaultImage L'image par défaut à utiliser en cas d'erreur.
     * @param string|null $currentImagePath Le chemin de l'image actuelle, si applicable.
     * @return array Tableau associatif contenant 'success' (bool), 'path' (string) et éventuellement 'error' (string).
     */
    public static function handleImageUpload($file, $uploadDir, $defaultImage, $currentImagePath = null) {
        $targetDir = "./uploads/$uploadDir/";

        // Créer le répertoire si nécessaire
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Vérifie si une image a été téléchargée sans erreur
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            error_log("Aucune nouvelle image téléchargée ou erreur détectée. Code erreur : " . ($file['error'] ?? 'non défini'));
            return [
                'success' => false,
                'error'   => 'Aucune image téléchargée ou erreur détectée.',
                'path'    => $currentImagePath ?? "$targetDir$defaultImage",
            ];
        }

        // Définir les contraintes sur le fichier
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2 Mo

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mimeType = mime_content_type($file['tmp_name']);

        if (!in_array($fileExtension, $allowedExtensions)) {
            error_log("Extension de fichier non valide : $fileExtension");
            return [
                'success' => false,
                'error'   => 'Extension de fichier non valide.',
            ];
        }

        if (!in_array($mimeType, $allowedMimeTypes)) {
            error_log("Type MIME non valide : $mimeType");
            return [
                'success' => false,
                'error'   => 'Type MIME non valide.',
            ];
        }

        if ($file['size'] > $maxFileSize) {
            error_log("Fichier trop volumineux : {$file['size']} octets");
            return [
                'success' => false,
                'error'   => 'Fichier trop volumineux.',
            ];
        }

        // Génère un nom unique pour le fichier uploadé
        $uniqueName = uniqid('img_') . '.' . $fileExtension;
        $targetFilePath = $targetDir . $uniqueName;

        // Déplace le fichier uploadé vers le répertoire cible
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            // Supprime l'ancienne image si elle existe et n'est pas l'image par défaut
            if ($currentImagePath && $currentImagePath !== "$targetDir$defaultImage" && file_exists($currentImagePath)) {
                if (unlink($currentImagePath)) {
                    error_log("Ancienne image supprimée : $currentImagePath");
                } else {
                    error_log("Échec de la suppression de l'image : $currentImagePath");
                }
            }
            error_log("Nouvelle image téléchargée avec succès : $targetFilePath");
            return [
                'success' => true,
                'path'    => $targetFilePath,
            ];
        }

        error_log("Échec du déplacement de l'image téléchargée vers $targetFilePath");
        return [
            'success' => false,
            'error'   => 'Échec du déplacement de l\'image téléchargée.',
            'path'    => $currentImagePath ?? "$targetDir$defaultImage",
        ];
    }

    /**
     * Supprime une image à partir de son chemin.
     *
     * Ne supprime pas l'image si son nom contient "default".
     *
     * @param string $imagePath Le chemin de l'image à supprimer.
     * @return void
     */
    public static function deleteImage(string $imagePath): void {
        $fullPath = __DIR__ . '/../uploads/' . $imagePath;
        if (file_exists($fullPath) && is_file($fullPath) && !str_contains($imagePath, 'default')) {
            unlink($fullPath);
        }
    }

    /**
     * Vérifie si l'utilisateur est connecté.
     *
     * Si la session ne contient pas d'utilisateur, redirige vers le formulaire de connexion.
     *
     * @return void
     */
    public static function checkIfUserIsConnected(): void {
        if (empty($_SESSION['user'])) {
            self::redirect("loginForm");
        }
    }
}
