<?php
require 'settings.php';
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
          if(move_uploaded_file($file_tmp, $missionsdir.$file_name)) {
            $query = "INSERT INTO missions(filename, name, minplayers, maxplayers, terrain, author, description, gamemode)
                          VALUES ('$file_name', '$missionname', '$minplayers', '$maxplayers', '$terrain', '$author', '$description', '$gamemode')";

}
}

if ($conn->query($query) === TRUE) {
  echo "New record created successfully";
}
else {
  echo "Error: " . $query . "<br />" . $conn->error;
}

$conn->close();


 ?>
