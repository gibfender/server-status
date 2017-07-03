<?php
require '../settings.php';
require_once 'res/library/HTMLPurifier.auto.php';
/*TODO When a new mission is uploaded, get php to generate a 4 character alphanumeric code. It can behave like a "password" for that file.(edited)
And if they want to overwrite it they just enter the code. */

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error); }


  if(isset($_POST['submit'])) {
    $file = $_FILES['file'];

    //File Properties
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    //metadata Properties
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $missionname = $purifier->purify($_POST['missionname']);
        $minplayers = $purifier->purify($_POST['minplayers']);
        $maxplayers = $purifier->purify($_POST['maxplayers']);
        $terrain = $purifier->purify($_POST['terrain']);
        $author = $purifier->purify($_POST['author']);
        $description = $purifier->purify($_POST['description']);
        $gamemode = $purifier->purify($_POST['gamemode']);

    //Work out the file extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

          //move the file from temp location to MPMissions folder
          if(move_uploaded_file($file_tmp, $missionsdir.$file_name)) {
            $query = "INSERT INTO missions(filename, dateupdated, name, minplayers, maxplayers, terrain, author, description, gamemode)
                          VALUES ('$file_name', CURDATE(), '$missionname', '$minplayers', '$maxplayers', '$terrain', '$author', '$description', '$gamemode')
                          ON DUPLICATE KEY UPDATE
                          dateupdated = CURDATE(),
                          name = '$missionname',
                          minplayers = '$minplayers',
                          maxplayers = '$maxplayers',
                          terrain = '$terrain',
                          author = '$author',
                          description = '$description',
                          gamemode = '$gamemode'";

}
}

if ($conn->query($query) === TRUE) {
  header('Location: /index.php');
  exit;
}
else {
  echo "Error: " . $query . "<br />" . $conn->error;
}

$conn->close();


 ?>
