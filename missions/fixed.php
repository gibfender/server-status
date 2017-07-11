<?php

require '../settings.php';
if (isset($_POST['id'])) {
    if (file_exists($brokendir.$_POST['filename'])) {
        rename($brokendir.$_POST['filename'], $missionsdir.$_POST['filename']);
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("UPDATE missions SET broken='0', brokentype=NULL, brokendes=NULL WHERE id=('".$_POST['id']."')");
        $stmt->execute();
        $conn = null;
    } else {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("UPDATE missions SET broken='0', brokentype=NULL, brokendes=NULL WHERE id=('".$_POST['id']."')");
        $stmt->execute();
        $conn = null;
    }
};
