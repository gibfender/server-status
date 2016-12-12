<?php

	require 'settings.php';

	// Create connection

	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	if (isset($_POST['submit'])) {
		$file_name = $_FILES['file']
		$missionname = $_SESSION['missionname'];
		$minplayers = $_SESSION['minplayers'];
		$maxplayers = $_SESSION['maxplayers'];
		$terrain = $_SESSION['terrain'];
		$author = $_SESSION['author'];
		$description = $_SESSION['description'];
		$gamemode = $_SESSION['gamemode'];
		$query = "INSERT INTO missions(name, minplayers, maxplayers, terrain, author, description, gamemode)
                  VALUES ('$missionname', '$minplayers', '$maxplayers', '$terrain', '$author', '$description', '$gamemode')";
	}

	if ($conn->query($query) === TRUE) {
		echo "New record created successfully";
	}
	else {
		echo "Error: " . $query . "<br />" . $conn->error;
	}

	$conn->close();


?>

<?php

/*TODO When a new mission is uploaded, get php to generate a 4 character alphanumeric code. It can behave like a "password" for that file.(edited)
And if they want to overwrite it they just enter the code. */

	require 'settings.php';

  if(isset($_FILES['file'])) {
    $file = $_FILES['file'];

    //File Properties
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    //Work out the file extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    //specify which extensions are allowed
    $allowed = array('pbo');

    //check that the file should be uploaded
    if (in_array($file_ext, $allowed)) {
      if ($file_error == 0) {
        if ($file_size <= 1000000) {
          $file_destination = "$missionsdir";
          //move the file from temp location to MPMissions folder
          if(move_uploaded_file($file_tmp, $file_destination.$file_name)) {
              echo "File Uploaded";
          }
        } else {
          echo "Your filesize was too big!";
        }
      } else {
        echo "There was an error with your upload";
      }
    } else {
      echo "Extension not allowed!";
    }

  }

 ?>
