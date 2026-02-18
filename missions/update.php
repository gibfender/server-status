<?php

require '../settings.php';
require_once 'db.php';

$id          = (int) $_POST['id'];
$missionname = $_POST['missionname'];
$datecreated = date("d-m-Y", strtotime($_POST['datecreated']));
$version     = $_POST['version'];
$minplayers  = (int) $_POST['minplayers'];
$maxplayers  = (int) $_POST['maxplayers'];
$terrain     = $_POST['terrain'];
$author      = $_POST['author'];
$description = $_POST['description'];
$gamemode    = $_POST['gamemode'];

$pdo = get_db();
$pdo->prepare("UPDATE missions SET
    name        = ?,
    datecreated = STR_TO_DATE(?, '%d-%m-%Y'),
    version     = ?,
    minplayers  = ?,
    maxplayers  = ?,
    terrain     = ?,
    author      = ?,
    description = ?,
    gamemode    = ?
    WHERE id    = ?")
->execute([$missionname, $datecreated, $version, $minplayers, $maxplayers, $terrain, $author, $description, $gamemode, $id]);

header('Location: /mission.php?id=' . $id);
exit;
