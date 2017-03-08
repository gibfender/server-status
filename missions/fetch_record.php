<?php

require_once '../settings.php';


//Include database connection
if($_POST['rowid']) {
    $id = $_POST['rowid']; //escape string
    try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT `filename`, `dateupdated`, `id`, `name`, `terrain`, `author`, `gamemode`, `minplayers`, `maxplayers`, `description`, `broken` FROM `missions` WHERE `id`=$_POST['rowid']");
          $stmt->execute();
          $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) {
          echo $row['name']
        }
    }
    catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
    }

    $conn = null;
 }
?>
