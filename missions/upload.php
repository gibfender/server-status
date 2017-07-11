<?php
require '../settings.php';

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


  if (isset($_POST['submit'])) {
      $file = $_FILES['file'];

    //File Properties
    $file_name = $file['name'];
      $file_tmp = $file['tmp_name'];
      $file_size = $file['size'];
      $file_error = $file['error'];

    //metadata Properties
    $missionname = $_POST['missionname'];
      $minplayers = $_POST['minplayers'];
      $maxplayers = $_POST['maxplayers'];
      $terrain = $_POST['terrain'];
      $author = $_POST['author'];
      $description = $_POST['description'];
      $gamemode = $_POST['gamemode'];

    //Work out the file extension
    $file_ext = explode('.', $file_name);
      $file_ext = strtolower(end($file_ext));

          //move the file from temp location to MPMissions folder
          if (move_uploaded_file($file_tmp, $missionsdir.$file_name)) {
              $query = "INSERT INTO missions(filename, datecreated, name, minplayers, maxplayers, terrain, author, description, gamemode)
                          VALUES ('$file_name', CURDATE(), '$missionname', '$minplayers', '$maxplayers', '$terrain', '$author', '$description', '$gamemode')
                          ON DUPLICATE KEY UPDATE
                          datecreated = CURDATE(),
                          name = '$missionname',
                          minplayers = '$minplayers',
                          maxplayers = '$maxplayers',
                          terrain = '$terrain',
                          author = '$author',
                          description = '$description',
                          gamemode = '$gamemode'";
          }
  }

if ($conn->query($query) === true) {
    header('Location: /index.php');
    exit;
} else {
    echo "Error: " . $query . "<br />" . $conn->error;
}

$conn->close();
