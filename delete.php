<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: audios.php");
    exit;
}

if (!isset($_POST["file"])) {
    header("Location: audios.php");
    exit;
}

$file = $_POST["file"];

// Empêcher les chemins dangereux
$file = basename($file);

$uploadDir = __DIR__ . "/uploads/";

$filePath = $uploadDir . $file;

// Extensions autorisées
$allowedExtensions = [
    "mp3",
    "wav",
    "ogg",
    "m4a",
    "aac",
    "flac"
];

$extension = strtolower(
    pathinfo($file, PATHINFO_EXTENSION)
);

// Vérifier que c'est bien un fichier audio autorisé
if (!in_array($extension, $allowedExtensions, true)) {
    die("Fichier non autorisé.");
}

// Vérifier que le fichier existe
if (!file_exists($filePath)) {
    die("Le fichier n'existe pas.");
}

// Supprimer le fichier
if (unlink($filePath)) {

    header("Location: audios.php");
    exit;

} else {

    die("Impossible de supprimer le fichier.");

}

?>
