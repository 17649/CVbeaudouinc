<?php
    $data = parse_ini_file("config.ini");
    if ($data === FALSE) {
        echo "Erreur de chargement du fichier de configuration.";
        die;
    }

    //var_dump($data);

    //Todo: le mettre dans le fichier .ini
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
<div id="background"></div>
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
  <div class="container">
    <div class="container-col">
      <section>
        <div class="title-group">
          <img src="assets/round_language_white_18dp.png">
          <span>Compétences</span>
        </div>
        <?php foreach ($data["SKILLS"] as $s): ?>
        <?php $s = explode(",", $s);?>
          <div class="skill-container">
            <span class="skill-name"><?= $s[0] ?></span>
            <div class="skill-dot-container">
              <?php for($k = $s[1]; $k > 0; $k -= 1): ?>
                <span class="skill-dot skill-dot-completed"></span>
              <?php endfor; ?>
              <?php for($k = 5 - $s[1]; $k > 0; $k -= 1): ?>
                <span class="skill-dot"></span>
              <?php endfor; ?>
            </div>
          </div>
        <?php endforeach; ?>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non vulputate lorem. Nam et nisl vel risus posuere efficitur. Etiam lacus nulla, bibendum vel diam eu, tempus commodo ipsum. Praesent eros enim, euismod vitae risus sit amet, molestie vehicula odio. Nullam rhoncus nisi vitae tellus mollis, rutrum gravida arcu auctor. Sed gravida purus id sapien vehicula, eu mattis erat pellentesque. Cras pharetra eros vel nulla mollis, vitae commodo nibh porttitor. Nulla ac libero posuere, pretium diam sit amet, convallis tellus. Vestibulum interdum, velit vitae eleifend pretium, nibh urna pulvinar nunc, eu viverra nulla ligula at est. Sed vitae euismod lacus, ac sollicitudin purus. Nunc a finibus arcu, vel scelerisque ex. </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non vulputate lorem. Nam et nisl vel risus posuere efficitur. Etiam lacus nulla, bibendum vel diam eu, tempus commodo ipsum. Praesent eros enim, euismod vitae risus sit amet, molestie vehicula odio. Nullam rhoncus nisi vitae tellus mollis, rutrum gravida arcu auctor. Sed gravida purus id sapien vehicula, eu mattis erat pellentesque. Cras pharetra eros vel nulla mollis, vitae commodo nibh porttitor. Nulla ac libero posuere, pretium diam sit amet, convallis tellus. Vestibulum interdum, velit vitae eleifend pretium, nibh urna pulvinar nunc, eu viverra nulla ligula at est. Sed vitae euismod lacus, ac sollicitudin purus. Nunc a finibus arcu, vel scelerisque ex. </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non vulputate lorem. Nam et nisl vel risus posuere efficitur. Etiam lacus nulla, bibendum vel diam eu, tempus commodo ipsum. Praesent eros enim, euismod vitae risus sit amet, molestie vehicula odio. Nullam rhoncus nisi vitae tellus mollis, rutrum gravida arcu auctor. Sed gravida purus id sapien vehicula, eu mattis erat pellentesque. Cras pharetra eros vel nulla mollis, vitae commodo nibh porttitor. Nulla ac libero posuere, pretium diam sit amet, convallis tellus. Vestibulum interdum, velit vitae eleifend pretium, nibh urna pulvinar nunc, eu viverra nulla ligula at est. Sed vitae euismod lacus, ac sollicitudin purus. Nunc a finibus arcu, vel scelerisque ex. </p>
      </section>
      <section>
        <div class="title-group">
          <img src="assets/round_language_white_18dp.png">
          <span>Langues parlées</span>
        </div>
        <img src="assets/flag_fr.svg">
      </section>
    </div>
    <div class="container-col">
      <section>
        <div class="title-group">
          <img src="assets/round_language_white_18dp.png">
          <span>Formations</span>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non vulputate lorem. Nam et nisl vel risus posuere efficitur. Etiam lacus nulla, bibendum vel diam eu, tempus commodo ipsum. Praesent eros enim, euismod vitae risus sit amet, molestie vehicula odio. Nullam rhoncus nisi vitae tellus mollis, rutrum gravida arcu auctor. Sed gravida purus id sapien vehicula, eu mattis erat pellentesque. Cras pharetra eros vel nulla mollis, vitae commodo nibh porttitor. Nulla ac libero posuere, pretium diam sit amet, convallis tellus. Vestibulum interdum, velit vitae eleifend pretium, nibh urna pulvinar nunc, eu viverra nulla ligula at est. Sed vitae euismod lacus, ac sollicitudin purus. Nunc a finibus arcu, vel scelerisque ex. </p>
      </section>
      <section>
        <div class="title-group">
          <img src="assets/round_language_white_18dp.png">
          <span>Expériences</span>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non vulputate lorem. Nam et nisl vel risus posuere efficitur. Etiam lacus nulla, bibendum vel diam eu, tempus commodo ipsum. Praesent eros enim, euismod vitae risus sit amet, molestie vehicula odio. Nullam rhoncus nisi vitae tellus mollis, rutrum gravida arcu auctor. Sed gravida purus id sapien vehicula, eu mattis erat pellentesque. Cras pharetra eros vel nulla mollis, vitae commodo nibh porttitor. Nulla ac libero posuere, pretium diam sit amet, convallis tellus. Vestibulum interdum, velit vitae eleifend pretium, nibh urna pulvinar nunc, eu viverra nulla ligula at est. Sed vitae euismod lacus, ac sollicitudin purus. Nunc a finibus arcu, vel scelerisque ex. </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non vulputate lorem. Nam et nisl vel risus posuere efficitur. Etiam lacus nulla, bibendum vel diam eu, tempus commodo ipsum. Praesent eros enim, euismod vitae risus sit amet, molestie vehicula odio. Nullam rhoncus nisi vitae tellus mollis, rutrum gravida arcu auctor. Sed gravida purus id sapien vehicula, eu mattis erat pellentesque. Cras pharetra eros vel nulla mollis, vitae commodo nibh porttitor. Nulla ac libero posuere, pretium diam sit amet, convallis tellus. Vestibulum interdum, velit vitae eleifend pretium, nibh urna pulvinar nunc, eu viverra nulla ligula at est. Sed vitae euismod lacus, ac sollicitudin purus. Nunc a finibus arcu, vel scelerisque ex. </p>
      </section>
      <section>
        <div class="title-group">
          <img src="assets/round_language_white_18dp.png">
          <span>Hobbies et intérêt</span>
        </div>
      </section>
    </div>
  </div>
</main>
</body>
</html>