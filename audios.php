<?php

$uploadDir = __DIR__ . "/uploads/";
$uploadUrl = "uploads/";

$allowedExtensions = [
    "mp3",
    "wav",
    "ogg",
    "m4a",
    "aac",
    "flac"
];

$files = [];

// Récupérer les fichiers audio
if (is_dir($uploadDir)) {

    $allFiles = scandir($uploadDir);

    foreach ($allFiles as $file) {

        if ($file === "." || $file === "..") {
            continue;
        }

        $extension = strtolower(
            pathinfo($file, PATHINFO_EXTENSION)
        );

        if (in_array($extension, $allowedExtensions, true)) {
            $files[] = $file;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mon audio</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>🎵 Mon fichier audio</h1>

    <a class="upload-link" href="index.php">
        ➕ Envoyer un nouvel audio
    </a>

    <?php if (empty($files)): ?>

        <div class="empty">
            <p>Aucun fichier audio disponible.</p>
        </div>

    <?php else: ?>

        <div class="audio-list">

            <?php foreach ($files as $file): ?>

                <div class="audio-card">

                    <h3>
                        🎵 <?= htmlspecialchars($file) ?>
                    </h3>

                    <!-- Lecteur audio -->
                    <audio controls>
                        <source
                            src="<?= $uploadUrl . rawurlencode($file) ?>"
                        >
                        Votre navigateur ne supporte pas l'audio.
                    </audio>

                    <div class="actions">

                        <!-- Télécharger -->
                        <a
                            class="download"
                            href="<?= $uploadUrl . rawurlencode($file) ?>"
                            download
                        >
                            ⬇️ Télécharger
                        </a>

                        <!-- Supprimer -->
                        <!-- <form
                            action="delete.php"
                            method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer cet audio ?');"
                        >

                            <input
                                type="hidden"
                                name="file"
                                value="<?= htmlspecialchars($file) ?>"
                            >

                            <button
                                type="submit"
                                class="delete"
                            >
                                🗑️ Supprimer
                            </button>

                        </form> -->

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

</body>

</html>
