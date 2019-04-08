<?php
    $data = parse_ini_file("config.ini");
    if ($data === FALSE) {
        echo "Erreur de chargement du fichier de configuration.";
        die;
    }

    $year = date_diff(date_create($data["BORN"]), new DateTime())->y;
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>CV en ligne</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <nav>
        <a href="#">Expériences</a>
        <a href="#">Compétences</a>
        <a href="#">Formation</a>
        <a href="#">Hobbies et intêrets</a>
        <a href="#">Contactez moi</a>
    </nav>
</header>
<main>
    <div class="title title-last-name"><?= $data['LAST_NAME']; ?></div>
    <div class="title title-first-name"><?= $data['FIRST_NAME']; ?></div>
    <div class="description">
        <p><?= $year; ?> ans // <?= $data['PHONE_NUMBER']; ?> // <?= $data['MAIL']; ?> //</p>
        <p><?= $data['ADDRESS']; ?></p>
    </div>
</main>
</body>
</html>