<?php

require '../settings.php';
require_once 'db.php';

if (!isset($_POST['id'], $_POST['filename'])) {
    http_response_code(400);
    exit;
}

$filename = basename($_POST['filename']);
$id       = (int) $_POST['id'];

if (file_exists($brokendir . $filename)) {
    rename($brokendir . $filename, $missionsdir . $filename);
}

$pdo = get_db();
$pdo->prepare("UPDATE missions SET broken='0', brokentype=NULL, brokendes=NULL WHERE id = ?")
    ->execute([$id]);

header('Location: /mission.php?id=' . $id);
exit;
