<?php

require '../settings.php';
require_once 'db.php';
require_once 'res/library/HTMLPurifier.auto.php';

if (!isset($_POST['id'], $_POST['filename'], $_POST['brokentype'], $_POST['brokendes'])) {
    http_response_code(400);
    exit;
}

$config    = HTMLPurifier_Config::createDefault();
$config->set('HTML.Allowed', '');
$purifier  = new HTMLPurifier($config);

$id        = (int) $_POST['id'];
$filename  = basename($_POST['filename']);
$brokentype = $purifier->purify($_POST['brokentype']);
$brokendes  = $purifier->purify($_POST['brokendes']);

if (file_exists($missionsdir . $filename)) {
    rename($missionsdir . $filename, $brokendir . $filename);
}

$pdo = get_db();
$pdo->prepare("UPDATE missions SET dateupdated = CURDATE(), broken = 1, brokentype = ?, brokendes = ? WHERE id = ?")
    ->execute([$brokentype, $brokendes, $id]);

header('Location: /mission.php?id=' . $id);
exit;
