<?php

require '../settings.php';
require_once 'res/library/HTMLPurifier.auto.php';
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);


rename($missionsdir.$_POST['filename'], $brokendir.$_POST['filename']);

        $id = $purifier->purify($_POST['id']);
        $filename = $purifier->purify($_POST['filename']);
        $brokentype = $purifier->purify($_POST['brokentype']);
        $brokendes = $purifier->purify($_POST['brokendes']);


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
