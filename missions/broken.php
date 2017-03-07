<?php

require '../settings.php';

if(isset($_POST['id'])) {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("UPDATE missions SET broken='1' WHERE id=('".$_POST['id']."')");
  $stmt->execute();
  $conn = null;
}

rename($missionsdir.$_POST['filename'], $brokendir.$_POST['filename']);
?>
