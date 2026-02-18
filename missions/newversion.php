<?php

require '../settings.php';
require_once 'db.php';
require_once 'res/library/HTMLPurifier.auto.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$config   = HTMLPurifier_Config::createDefault();
$config->set('HTML.Allowed', 'p[align|style],strong,a[href],em,table[class|width|cellpadding],td,tr,h3,h4,h5,hr,br,u,ul,ol,li');
$purifier = new HTMLPurifier($config);

$id      = (int) $_POST['id'];
$version = strip_tags($_POST['version'] ?? '');
$note    = $purifier->purify($_POST['note'] ?? '');

$name    = basename($_FILES['file']['name']);
$tmpName = $_FILES['file']['tmp_name'];
$error   = $_FILES['file']['error'];
$size    = $_FILES['file']['size'];
$ext     = strtolower(pathinfo($name, PATHINFO_EXTENSION));

switch ($error) {
    case UPLOAD_ERR_OK:
        break;
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
        echo "File exceeds maximum allowed size.";
        exit;
    case UPLOAD_ERR_PARTIAL:
        echo "File was only partially uploaded.";
        exit;
    case UPLOAD_ERR_NO_FILE:
        echo "No file was uploaded.";
        exit;
    default:
        error_log("Upload error code: $error");
        echo "An error occurred during upload.";
        exit;
}

if (!in_array($ext, ['pbo'])) {
    http_response_code(400);
    echo "Invalid file extension. Only .pbo files are allowed.";
    exit;
}

if ($size > 20 * 1024 * 1024) {
    http_response_code(400);
    echo "File size exceeds the 20 MB limit.";
    exit;
}

// Update version and add release notes
$pdo = get_db();
$pdo->prepare("UPDATE missions SET dateupdated = CURDATE(), version = ? WHERE id = ?")
    ->execute([$version, $id]);
$pdo->prepare("INSERT INTO releasenotes (version, note, date, id) VALUES (?, ?, CURDATE(), ?)")
    ->execute([$version, $note, $id]);

// Move to the correct folder depending on current location
if (file_exists($missionsdir . $name)) {
    move_uploaded_file($tmpName, $missionsdir . $name);
} else {
    move_uploaded_file($tmpName, $brokendir . $name);
}

header('Location: /mission.php?id=' . $id);
exit;
