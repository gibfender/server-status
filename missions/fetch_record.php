<?php

require_once '../settings.php';


//Include database connection
if($_POST['id']) {
    $test = "Test";
    $id = $_POST['id']; //escape string
    /*try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT filename, dateupdated, id, name, terrain, author, gamemode, minplayers, maxplayers, description, broken FROM missions WHERE id=$id");
          $stmt->execute();
          $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()) {
          echo $id;
          echo $row['filename'];
          echo $row['dateupdated'];
          echo $row['name'];
          echo $row['terrain'];
          echo $row['gamemode'];
          echo $row['minplayers'];
          echo $row['maxplayers'];
          echo $row['description'];
          echo $row['broken'];
        }
    }
    catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
    }

    $conn = null;*/
    echo "$test";
 }
?>
