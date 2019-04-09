<?php
    $data = parse_ini_file("config.ini");
    if ($data === FALSE) {
        echo "Erreur de chargement du fichier de configuration.";
        die;
    }

    $year = date_diff(date_create($data["BORN"]), new DateTime())->y;

    if (isset($_GET['page']) && !empty($_GET['page'])) {
        switch ($_GET['page']) {
            case 'expériences':
                $sectionName = "Mes expériences";
                break;
            case "compétences":
                $sectionName = "Mes compétences";
                break;
            case "formation":
                $sectionName = "Ma formation";
                break;
            case "hobbies":
                $sectionName = "Mes hobbies et intérêts";
                break;
            case "contact":
                $sectionName = "Me contacter";
                break;
            default:
                $sectionName = "";
        }
    }

$menu = [
    [urlencode("expériences"), "Expériences", "Mes expériences"],
    [urlencode("compétences"), "Compétences", "Mes compétences"],
    [urlencode("formation"), "Formation", "Ma formation"],
    [urlencode("hobbies"), "Hobbies et intêrets", "Mes hobbies et intêrets"],
    [urlencode("contact"), "Contactez-moi", "Me contacter"]
];

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
    <div class="title"><?= $sectionName ?></div>
    <div class="description">
        <p><?= $year; ?> ans // <?= $data['PHONE_NUMBER']; ?> // <?= $data['MAIL']; ?> //</p>
        <p><?= $data['ADDRESS']; ?></p>
    </div>
</main>
</body>
</html>