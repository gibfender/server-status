<?php

require '../settings.php';
require_once 'db.php';
require_once 'res/library/HTMLPurifier.auto.php';

$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.Allowed', 'p[align|style],strong,a[href],em,table[class|width|cellpadding],td,tr,h3,h4,h5,hr,br,u,ul,ol,li');
$purifier = new HTMLPurifier($config);

$id        = (int) $_POST['id'];
$version   = strip_tags($_POST['version'] ?? '');
$commenter = strip_tags($_POST['commenter'] ?? '');
$comment   = $purifier->purify($_POST['comment'] ?? '');

$pdo = get_db();
$pdo->prepare("INSERT INTO comments (name, comment, version, id, date) VALUES (?, ?, ?, ?, CURDATE())")
    ->execute([$commenter, $comment, $version, $id]);

header('Location: /mission.php?id=' . $id);
exit;
