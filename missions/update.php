<?php

require '../settings.php';

        $id = $_POST['id'];
        $missionname = $_POST['missionname'];
        $datecreated = date("Y-m-d", strtotime($_POST['datecreated']));
        $version = $_POST['version'];
        $minplayers = $_POST['minplayers'];
        $maxplayers = $_POST['maxplayers'];
        $terrain = $_POST['terrain'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $gamemode = $_POST['gamemode'];


        $dsn = "mysql:host=$servername;dbname=$dbname;";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
          ];
        $pdo = new PDO($dsn, $username, $password, $opt);
        $sql = "UPDATE missions SET
                                    dateupdated = CURDATE(),
                                    name = ?,
                                    version = ?,
                                    minplayers = ?,
                                    maxplayers = ?,
                                    terrain = ?,
                                    author = ?,
                                    description = ?,
                                    gamemode = ?
                                    WHERE id = '$id'";
        $pdo->prepare($sql)->execute([$missionname,$vesion,$minplayers,$maxplayers,$terrain,$author,$description,$gamemode]);
        var_dump($missionname);
?>
