<?php

require '../settings.php';

rename($missionsdir.$_POST['filename'], $brokendir.$_POST['filename']);

        $id = $_POST['id'];
        $filename = $_POST['filename'];
        $brokentype = $_POST['brokentype'];
        $brokendes = $_POST['brokendes'];


        $dsn = "mysql:host=$servername;dbname=$dbname;";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
          ];
        $pdo = new PDO($dsn, $username, $password, $opt);
        $sql = "UPDATE missions SET
                                    dateupdated = CURDATE(),
                                    broken = ?,
                                    brokentype = ?,
                                    brokendes = ?
                                    WHERE id = '$id'";
        $pdo->prepare($sql)->execute([1,$brokentype,$brokendes]);
        header('Location: /mission.php?id='.$id);

?>
