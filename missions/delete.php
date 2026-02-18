<?php

require '../settings.php';
require_once 'db.php';

if (!isset($_POST['id'], $_POST['filename'])) {
    http_response_code(400);
    exit;
}

// basename() prevents path traversal (e.g. ../../settings.php)
$filename = basename($_POST['filename']);

if (file_exists($missionsdir . $filename)) {
    rename($missionsdir . $filename, $deleteddir . $filename);
} elseif (file_exists($brokendir . $filename)) {
    rename($brokendir . $filename, $deleteddir . $filename);
}

$pdo = get_db();
$id  = (int) $_POST['id'];

$pdo->prepare("DELETE FROM missions      WHERE id = ?")->execute([$id]);
$pdo->prepare("DELETE FROM comments     WHERE id = ?")->execute([$id]);
$pdo->prepare("DELETE FROM releasenotes WHERE id = ?")->execute([$id]);

header('Location: /');
exit;
