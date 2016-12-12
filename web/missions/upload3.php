<?php require 'settings.php'; ?>
<?php

	require 'settings.php'

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
          $file_destination = $missionsdir;
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

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="res/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="res/css/custom.css">
	<script type="text/javascript" src="res/js/jquery-2.1.4.min.js"></script>
	<link rel="shortcut icon" href="/res/images/favicon.ico">

	<title><?php echo "$groupname"; ?> Missions</title>

	<script>
		$.get("nav.html", function(data) {
			$("#nav-placeholder").replaceWith(data);
		});
	</script>
  <script language="javascript">
function() submitForms{
document.getElementById("file_upload").submit();
document.getElementById("mission_meta").submit();
}
</script>
</head>

<body>



</body>
</html>
