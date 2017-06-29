<?php

require '../settings.php';

rename($brokendir.$_POST['filename'], $missionsdir.$_POST['filename']);

if(isset($_POST['id'])) {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("UPDATE missions SET broken='0' WHERE id=('".$_POST['id']."')");
  $stmt->execute();
  $conn = null;
}

?>
