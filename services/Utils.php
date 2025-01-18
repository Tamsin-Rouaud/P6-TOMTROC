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

    public static function handleImageUpload($file, $uploadDir, $defaultImage)
    {
        $targetDir = "./uploads/$uploadDir/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return "$targetDir$defaultImage";
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024;

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions) || 
            !in_array(mime_content_type($file['tmp_name']), $allowedMimeTypes) || 
            $file['size'] > $maxFileSize) {
            return "$targetDir$defaultImage";
        }

        $uniqueName = uniqid('img_') . '.' . $fileExtension;
        $targetFilePath = $targetDir . $uniqueName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $targetFilePath;
        }

        error_log("Échec du déplacement de l'image vers $targetFilePath");
        return "$targetDir$defaultImage";
    }

    public static function deleteImage(string $imagePath): void
    {
        $fullPath = __DIR__ . '/../uploads/' . $imagePath;

        if (file_exists($fullPath) && is_file($fullPath) && !str_contains($imagePath, 'default')) {
            unlink($fullPath);
        }
    }

    // public static function startSession(): void
    // {
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }
    // }

    public static function checkIfUserIsConnected(): void
    {
        // self::startSession();
        // var_dump($_SESSION);
        
        if (empty($_SESSION['user'])) {
            //debogage
            // var_dump($_SESSION);
            // die;
            self::redirect("loginForm");
        }
    }
}