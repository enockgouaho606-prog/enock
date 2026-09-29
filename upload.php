<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

if (!isset($_FILES["audio"])) {
    die("Aucun fichier sélectionné.");
}

$file = $_FILES["audio"];

// Vérification de l'erreur d'upload
if ($file["error"] !== UPLOAD_ERR_OK) {
    die("Une erreur est survenue pendant l'envoi.");
}

// Taille maximale : 20 Mo
$maxSize = 100 * 1024 * 1024; // 100 Mo

if ($file["size"] > $maxSize) {
    die("Le fichier est trop volumineux. Maximum : 20 Mo.");
}

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
    pathinfo($file["name"], PATHINFO_EXTENSION)
);

if (!in_array($extension, $allowedExtensions, true)) {
    die("Format audio non autorisé.");
}

// Création du dossier uploads s'il n'existe pas
$uploadDir = __DIR__ . "/uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Nom unique pour éviter les conflits
$newName = uniqid("audio_", true) . "." . $extension;

$destination = $uploadDir . $newName;

// Déplacement du fichier
if (move_uploaded_file($file["tmp_name"], $destination)) {

    // Redirection vers la liste des fichiers
    header("Location: audios.php");
    exit;

} else {

    die("Impossible d'enregistrer le fichier.");

}
?>
