<?php
    $data = parse_ini_file("config.ini");
    if ($data === FALSE) {
        echo "Erreur de chargement du fichier de configuration.";
        die;
    }

    $menu = [
        [urlencode("expériences"), "Expériences", "Mes expériences"],
        [urlencode("compétences"), "Compétences", "Mes compétences"],
        [urlencode("formation"), "Formation", "Ma formation"],
        [urlencode("hobbies"), "Hobbies et intêrets", "Mes hobbies et intêrets"],
        [urlencode("contact"), "Contactez-moi", "Me contacter"]
    ];

    $year = date_diff(date_create($data["BORN"]), new DateTime())->y;

    $sectionName = "";
    if (isset($_GET['page']) && !empty($_GET['page'])) {
        foreach ($menu as $m) {
            if (urldecode($_GET['page']) === urldecode($m[0])) {
                $sectionName = $m[2];
            }
        }
    }
?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>CV en ligne</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <nav>
        <?php foreach ($menu as $m): ?>
        <a href="?page=<?= $m[0]; ?>"><?= $m[1]; ?></a>
        <?php endforeach; ?>
    </nav>
</header>
<main>
    <div class="title title-last-name"><?= $data['LAST_NAME']; ?></div>
    <div class="title title-first-name"><?= $data['FIRST_NAME']; ?></div>
    <div class="description">
        <p><?= $year; ?> ans // <?= $data['PHONE_NUMBER']; ?> // <?= $data['MAIL']; ?> //</p>
        <p><?= $data['ADDRESS']; ?></p>
    </div>
    <div class="section-title"><?= $sectionName ?></div>
</main>
</body>
</html>