<?php

//services/Utils.php

/**
 * Classe utilitaire : cette classe ne contient que des méthodes statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Utils.
 */
class Utils {
    
    /**
     * Convertit une date vers le format de type "Samedi 15 juillet 2023" en français.
     * Cette méthode utilise IntlDateFormatter pour formater la date selon les conventions françaises.
     * 
     * @param DateTime $date : la date à convertir.
     * @return string : la date convertie au format "Samedi 15 juillet 2023".
     */
    public static function convertDateToFrenchFormat(DateTime $date) : string
    {
        // Utilisation de l'IntlDateFormatter pour formater la date au format souhaité.
        // L'extension intl doit être activée pour que cette méthode fonctionne.
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('EEEE d MMMM Y');
        return $dateFormatter->format($date);
    }

    
    /**
     * Redirige vers une URL spécifiée avec des paramètres optionnels.
     * Cette méthode est utilisée pour rediriger l'utilisateur vers une autre action de l'application.
     * 
     * @param string $action : l'action vers laquelle rediriger (par exemple, une action du routeur).
     * @param array $params : Facultatif, un tableau de paramètres à ajouter à l'URL de redirection.
     * @return void
     */
    public static function redirect(string $action, array $params = []) : void
{
    $url = "index.php?action=" . urlencode($action);
    foreach ($params as $paramName => $paramValue) {
        $url .= "&" . urlencode($paramName) . "=" . urlencode($paramValue);
    }
    header("Location: $url");
    exit();
}


    /**
     * Génère le code JavaScript à insérer dans un bouton pour afficher une boîte de confirmation.
     * Si l'utilisateur clique sur "Ok", l'action sera effectuée.
     * 
     * @param string $message : le message à afficher dans la boîte de confirmation.
     * @return string : le code JavaScript à insérer dans l'attribut "onclick" d'un bouton.
     */
    public static function askConfirmation(string $message) : string
    {
        // Retourne un code JavaScript qui affiche une boîte de confirmation avant d'effectuer l'action.
        return "onclick=\"return confirm('$message');\"";
    }

    /**
     * Protège une chaîne de caractères contre les attaques XSS (Cross-site Scripting).
     * Cette méthode convertit les caractères spéciaux en entités HTML et transforme les retours à la ligne en balises <p>.
     * 
     * @param string $string : la chaîne à protéger contre les attaques XSS.
     * @return string : la chaîne protégée avec htmlspecialchars et les retours à la ligne convertis.
     */
    public static function format(string $string) : string
    {
        // Etape 1 : Utilisation de htmlspecialchars pour échapper les caractères spéciaux et prévenir les attaques XSS.
        $finalString = htmlspecialchars($string, ENT_QUOTES);

        // Etape 2 : Transformation des retours à la ligne en balises <p> pour un affichage agréable.
        $lines = explode("\n", $finalString);
        $finalString = "";
        foreach ($lines as $line) {
            if (trim($line) != "") {
                $finalString .= "<p>$line</p>";
            }
        }
        
        return $finalString;
    }

    /**
     * Récupère une variable de la superglobale $_REQUEST.
     * Si la variable n'est pas définie, retourne une valeur par défaut.
     * 
     * @param string $variableName : le nom de la variable à récupérer.
     * @param mixed $defaultValue : la valeur par défaut si la variable n'est pas définie.
     * @return mixed : la valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null) : mixed
    {
        // Si la variable existe dans $_REQUEST, on retourne sa valeur, sinon on retourne la valeur par défaut.
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    public static function handleImageUpload($file, $uploadDir, $defaultImage, $oldImagePath = null) {
        // Dossier cible pour l'upload
        $targetDir = "./uploads/$uploadDir/";
    
        // Vérifie et crée le dossier cible s'il n'existe pas
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    
        // Si aucun fichier n'a été téléchargé, retourne l'image par défaut
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return $oldImagePath ? $oldImagePath : "$targetDir$defaultImage"; // Retourne l'ancienne image si elle existe, sinon l'image par défaut
        }
    
        // Vérifie le type MIME et la taille maximale
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2 Mo
    
        // Si l'image téléchargée n'est pas valide, retourne l'image par défaut
        if (!in_array(mime_content_type($file['tmp_name']), $allowedMimeTypes) || $file['size'] > $maxFileSize) {
            return $oldImagePath ? $oldImagePath : "$targetDir$defaultImage"; // Retourne l'ancienne image en cas d'erreur
        }
    
        // Supprime l'ancienne image si elle existe et n'est pas l'image par défaut
        if ($oldImagePath && $oldImagePath !== "$targetDir$defaultImage" && file_exists($oldImagePath)) {
            unlink($oldImagePath); // Supprime l'ancienne image
        }
    
        // Génère un nom unique pour l'image téléchargée
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('img_') . '.' . $fileExtension;
        $targetFilePath = $targetDir . $uniqueName;
    
        // Déplace l'image vers le dossier cible
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $targetFilePath; // Retourne le chemin de l'image enregistrée
        }
    
        // En cas d'échec, retourne l'ancienne image ou l'image par défaut
        return $oldImagePath ? $oldImagePath : "$targetDir$defaultImage"; // Si l'upload échoue, retourne l'ancienne image ou l'image par défaut
    }
    
    
}
