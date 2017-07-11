<?php

  include '../settings.php';
  require_once 'res/library/HTMLPurifier.auto.php';

  $config = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($config);
  $id = $purifier->purify($_POST['id']);

  $config = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($config);
  $commenter = $purifier->purify($_POST['commenter']);

  $config = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($config);
  $version = $purifier->purify($_POST['version']);

  $config = HTMLPurifier_Config::createDefault();
  $config->set('HTML.Allowed', 'p[align|style],strong,a[href],em,table[class|width|cellpadding],td,tr,h3,h4,h5,hr,br,u,ul,ol,li');
  $purifier = new HTMLPurifier($config);
  $comment = $purifier->purify($_POST['comment']);

  $dsn = "mysql:host=$servername;dbname=$dbname;";
  $opt = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
    ];
  $pdo = new PDO($dsn, $username, $password, $opt);
  $sql = "INSERT INTO comments(name,comment,version,id,date)
          VALUES (?,?,?,?,CURDATE())";
  $stmt=$pdo->prepare($sql)->execute([$commenter,$comment,$version,$id]);
  error_log($stmt);
  $stmt=null;
  header('Location: /mission.php?id='.$_POST['id']);

 ?>
