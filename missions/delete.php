<?php

require '../settings.php';

if (file_exists($missionsdir.$_POST['filename'])) {
    rename($missionsdir.$_POST['filename'], $deleteddir.$_POST['filename']);
} else {
    rename($brokendir.$_POST['filename'], $deleteddir.$_POST['filename']);
}

if (isset($_POST['id'])) {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("DELETE FROM missions WHERE id=('".$_POST['id']."')");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM comments WHERE id=('".$_POST['id']."')");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM releasenotes WHERE id=('".$_POST['id']."')");
    $stmt->execute();
    $conn = null;
}
header('Location: /');
