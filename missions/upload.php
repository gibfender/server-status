<?php

require '../settings.php';
require_once 'db.php';

if (!isset($_POST['submit'])) {
    http_response_code(400);
    exit;
}

$file       = $_FILES['file'];
$file_name  = basename($file['name']);   // basename() prevents path traversal
$file_tmp   = $file['tmp_name'];
$file_size  = $file['size'];
$file_error = $file['error'];
$file_ext   = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

$missionname = $_POST['missionname'];
$minplayers  = (int) $_POST['minplayers'];
$maxplayers  = (int) $_POST['maxplayers'];
$terrain     = $_POST['terrain'];
$author      = $_POST['author'];
$description = $_POST['description'];
$gamemode    = $_POST['gamemode'];

if ($file_error !== UPLOAD_ERR_OK) {
    error_log("Upload error code: $file_error");
    http_response_code(400);
    echo "File upload failed. Please try again.";
    exit;
}

if ($file_ext !== 'pbo') {
    http_response_code(400);
    echo "Only .pbo files are allowed.";
    exit;
}

if ($file_size > 20 * 1024 * 1024) {
    http_response_code(400);
    echo "File size exceeds the 20 MB limit.";
    exit;
}

if (!move_uploaded_file($file_tmp, $missionsdir . $file_name)) {
    error_log("move_uploaded_file failed for: $file_name");
    http_response_code(500);
    echo "Could not save the uploaded file.";
    exit;
}

$pdo = get_db();
$pdo->prepare("INSERT INTO missions
    (filename, datecreated, dateupdated, name, minplayers, maxplayers, terrain, author, description, gamemode, version)
    VALUES (?, CURDATE(), CURDATE(), ?, ?, ?, ?, ?, ?, ?, '1.0.0')")
->execute([$file_name, $missionname, $minplayers, $maxplayers, $terrain, $author, $description, $gamemode]);

header('Location: /index.php');
exit;
