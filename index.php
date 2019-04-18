<?php

    function transmitError($e = "") {
      echo $e;
      http_response_code(400);
      die;
    }

    function transmitJson($d) {
      header("Content-Type: application/json");
      echo json_encode($d);
      die;
    }

    $data = parse_ini_file("config.ini");
    if ($data === FALSE) {
        echo "Erreur de chargement du fichier de configuration.";
        die;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $pdo = new PDO("mysql:host=$data[DB_URL];dbname=$data[DB_NAME]", $data["DB_USER"], $data["DB_PASS"]);

      if (isset($_POST['password'])) {
        if (htmlspecialchars(stripslashes(trim($_POST['password']))) !== $data["CONTACT_PASS"]) {
          transmitError();
        } else {
          $q = $pdo->prepare("SELECT * FROM $data[DB_TABLE_NAME] ORDER BY ID DESC LIMIT 5");
          $q->execute();
          transmitJson($q->fetchAll());
        }
      }

      if (!isset($_POST['lastname']) || !isset($_POST['firstname'])
        || !isset($_POST['email']) || !isset($_POST['content'])) {
        transmitError("Une erreur est survenue.");
      }

      $lastName = htmlspecialchars(stripslashes(trim($_POST['lastname'])));
      $firstName = htmlspecialchars(stripslashes(trim($_POST['firstname'])));
      $email = htmlspecialchars(stripslashes(trim($_POST['email'])));
      $content = htmlspecialchars(stripslashes(trim($_POST['content'])));

      if (empty($lastName) || empty($firstName) || empty($email) || empty($content))
        transmitError("Une erreur est survenue.");
      else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        transmitError("Votre email est invalide.");



      $pdo->exec("CREATE TABLE IF NOT EXISTS $data[DB_TABLE_NAME] ($data[DB_TABLE_STRUCT]);");
      $q = $pdo->prepare("INSERT INTO $data[DB_TABLE_NAME] (lastname, firstname, email, content, posted_at) VALUES (?, ?, ?, ?, NOW())");
      $q->execute([$lastName, $firstName, $email, $content]);
      var_dump($q->errorInfo());
      die;
    }

    $year = date_diff(date_create($data["BORN"]), new DateTime())->y;

?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>CV en ligne</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div id="contact-viewer" class="modal">
  <img src="assets/close.svg" title="Fermer la lecture des messages" id="close-contact-viewer">
  <div class="modal-header">
    <div class="modal-title">Mes messages</div>
  </div>
  <div class="contact-viewer-element">
    <div class="contact-viewer-desc">
      <span class="contact-viewer-desc-name">De : Benoît SAINT-ETIENNE</span>
      <span class="contact-viewer-desc-date">le 12 juin 1997 à 23h47</span>
    </div>
    <textarea readonly>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean interdum vulputate aliquet. Vivamus sed felis vulputate, rhoncus nisl eu, posuere quam. Mauris luctus ligula ligula, ut semper tortor commodo in. Fusce blandit consectetur aliquet. Fusce et dapibus ante. Aliquam a scelerisque lacus. Pellentesque tempor ante tellus, porttitor bibendum neque malesuada in. Aliquam erat volutpat. Nulla dui lorem, auctor a commodo et, porta eget magna. Vestibulum ut libero malesuada, iaculis metus a, mattis risus. Suspendisse nec felis sagittis, sagittis ante quis, tincidunt urna. Fusce tincidunt enim at elit viverra interdum. </textarea>
  </div>
</div>
<div id="contact" class="modal">
  <img src="assets/close.svg" title="Fermer le formulaire de contact" id="close-contact">
  <img src="assets/key.svg" title="Accéder à la lecture des messages" id="view-contact">
  <div class="modal-header">
    <div class="modal-title">Me contacter</div>
    <div id="contact-info"></div>
  </div>

  <form>
    <div class="form-row form-row-two-column">
      <div class="form-column">
        <label for="lastname">Votre nom :</label>
        <input type="text" name="lastname" id="lastname" required>
      </div>
      <div class="form-column">
        <label for="lastname">Votre prenom :</label>
        <input type="text" name="firstname" id="firstname" required>
      </div>
    </div>
    <div class="form-row">
      <label for="lastname">Votre adresse email :</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div class="form-row">
      <label for="content">Votre message :</label>
      <textarea name="content" id="content" required></textarea>
    </div>
    <div class="form-row">
      <button type="button" id="send-contact">Envoyer le commentaire</button>
    </div>
  </form>
</div>
<div id="background"></div>
<header>
    <nav>
      <a href="#expériences">Expériences</a>
      <a href="#compétences">Compétences</a>
      <a href="#formation">Formation</a>
      <a href="#hobbies">Hobbies et intêrets</a>
      <a href="" id="open-contact">Contactez-moi</a>
    </nav>
</header>
<main>
    <div class="title"><?= $data['LAST_NAME']; ?> <?= $data['FIRST_NAME']; ?></div>
    <div class="description">
        <p><?= $year; ?> ans // <?= $data['PHONE_NUMBER']; ?> // <?= $data['MAIL']; ?> //</p>
        <p><?= $data['ADDRESS']; ?></p>
    </div>
  <div class="container">
    <div class="container-col">
      <section>
        <div class="title-group" id="compétences">
          <img src="assets/skill.svg">
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
        </section>
      <section>
        <div class="title-group">
          <img src="assets/round_language_white_18dp.png">
          <span>Langues parlées</span>
        </div>
        <div class="lang-container">
          <?php foreach ($data["LANG"] as $l): ?>
            <img src="assets/<?= $l; ?>">
          <?php endforeach; ?>
        </div>
      </section>
    </div>
    <div class="container-col">
      <section>
        <div class="title-group" id="formation">
          <img src="assets/mortarboard.svg">
          <span>Formations</span>
        </div>
        <div class="grad-group">
          <span class="grad-vertical"></span>
          <?php foreach ($data["TRAINING"] as $t): ?>
          <?php $t = explode(",", $t); ?>
            <div class="grad-container">
              <span class="grad-title"><?= $t[0]; ?></span>
              <span class="grad-dot"></span>
              <div class="grad-desc">
                <div class="grad-desc-title"><?= $t[1]; ?></div>
                <div class="grad-desc-desc"><?= $t[2]; ?></div>
              </div>
              <span class="grad-date"><?= $t[3]; ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
      <section>
        <div class="title-group" id="expériences">
          <img src="assets/achievement.svg">
          <span>Expériences</span>
        </div>
        <div class="grad-group">
          <span class="grad-vertical"></span>
          <?php foreach ($data["EXPERIENCES"] as $t): ?>
            <?php $t = explode(",", $t); ?>
            <div class="grad-container">
              <span class="grad-title"><?= $t[0]; ?></span>
              <span class="grad-dot"></span>
              <div class="grad-desc">
                <div class="grad-desc-title"><?= $t[1]; ?></div>
                <div class="grad-desc-desc"><?= $t[2]; ?></div>
              </div>
              <span class="grad-date"><?= $t[3]; ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
      <section>
        <div class="title-group" id="hobbies">
          <img src="assets/canvas.svg">
          <span>Hobbies et intérêt</span>
        </div>
        <div class="hobbies-container">
          <?php foreach ($data["HOBBIES"] as $l): ?>
          <?php $l = explode(",", $l); ?>
            <div>
              <img src="assets/<?= $l[0]; ?>">
              <span><?= $l[1]; ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </div>
</main>
<script src="app.js"></script>
</body>
</html>