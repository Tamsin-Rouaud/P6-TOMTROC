<?php

class Utils {

    public static function convertDateToFrenchFormat(DateTime $date): string
    {
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('EEEE d MMMM Y');
        return $dateFormatter->format($date);
    }

    public static function redirect(string $action, array $params = []): void
    {
        $url = "index.php?action=" . urlencode($action);
        foreach ($params as $paramName => $paramValue) {
            $url .= "&" . urlencode($paramName) . "=" . urlencode($paramValue);
        }
        header("Location: $url");
        exit();
    }

    public static function askConfirmation(string $message): string
    {
        return "onclick=\"return confirm('$message');\"";
    }

    public static function format(string $string, bool $convertNewLines = true): string
    {
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

    public static function request(string $variableName, mixed $defaultValue = null): mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

// Proposition handleupload
    // public function handleImageUpload(array $file, string $uploadDir, string $defaultImage): array
    // {
    //     $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    //     $maxFileSize = 2 * 1024 * 1024; // 2 Mo
    
    //     if (!in_array($file['type'], $allowedMimeTypes)) {
    //         return ['success' => false, 'error' => 'Format de fichier non supporté'];
    //     }
    //     if ($file['size'] > $maxFileSize) {
    //         return ['success' => false, 'error' => 'Fichier trop volumineux'];
    //     }
    
    //     $fileName = uniqid() . '_' . basename($file['name']);
    //     $targetPath = $uploadDir . $fileName;
    
    //     if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    //         return ['success' => true, 'path' => $targetPath];
    //     } else {
    //         return ['success' => false, 'error' => 'Erreur lors du téléchargement'];
    //     }
    // }
    






    public static function handleImageUpload($file, $uploadDir, $defaultImage, $currentImagePath = null)
{
    $targetDir = "./uploads/$uploadDir/";

    // Créer le répertoire si nécessaire
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Si aucune image n'est téléchargée ou qu'une erreur est survenue
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        error_log("Aucune nouvelle image téléchargée ou erreur détectée. Code erreur : " . ($file['error'] ?? 'non défini'));
        return [
            'success' => false,
            'error' => 'Aucune image téléchargée ou erreur détectée.',
            'path' => $currentImagePath ?? "$targetDir$defaultImage",
        ];
    }

    // Vérifier les contraintes sur le fichier
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2 Mo

    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $mimeType = mime_content_type($file['tmp_name']);

    if (!in_array($fileExtension, $allowedExtensions)) {
        error_log("Extension de fichier non valide : $fileExtension");
        return [
            'success' => false,
            'error' => 'Extension de fichier non valide.',
        ];
    }

    if (!in_array($mimeType, $allowedMimeTypes)) {
        error_log("Type MIME non valide : $mimeType");
        return [
            'success' => false,
            'error' => 'Type MIME non valide.',
        ];
    }

    if ($file['size'] > $maxFileSize) {
        error_log("Fichier trop volumineux : {$file['size']} octets");
        return [
            'success' => false,
            'error' => 'Fichier trop volumineux.',
        ];
    }

    // Générer un nom unique pour le fichier
    $uniqueName = uniqid('img_') . '.' . $fileExtension;
    $targetFilePath = $targetDir . $uniqueName;

    // Déplacer l'image téléchargée
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Supprimer l'ancienne image si elle existe et n'est pas l'image par défaut
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
            'path' => $targetFilePath,
        ];
    }

    error_log("Échec du déplacement de l'image téléchargée vers $targetFilePath");
    return [
        'success' => false,
        'error' => 'Échec du déplacement de l\'image téléchargée.',
        'path' => $currentImagePath ?? "$targetDir$defaultImage",
    ];
}


    public static function deleteImage(string $imagePath): void
    {
        $fullPath = __DIR__ . '/../uploads/' . $imagePath;

        if (file_exists($fullPath) && is_file($fullPath) && !str_contains($imagePath, 'default')) {
            unlink($fullPath);
        }
    }



    public static function checkIfUserIsConnected(): void
    {
            
        if (empty($_SESSION['user'])) {
         
            self::redirect("loginForm");
        }
    }
}