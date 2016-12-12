<?php require 'settings.php'; ?>
<?php

 // starting the session
 $status = session_status();
	if($status == PHP_SESSION_NONE){
			//There is no active session
			session_start();
	}else
	if($status == PHP_SESSION_DISABLED){
			//Sessions are not available
	}else
	if($status == PHP_SESSION_ACTIVE){
			//Destroy current and start new one
			session_destroy();
			session_start();
	}?>
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
    $.get("res/nav.html", function(data){
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
	<div id="nav-placeholder"></div>

	<div class="container">
    <?php
    session_start(); // Session starts here.
    ?>
		<form class="form-horizontal" id="mission_meta" action="upload2.php" method="post"  enctype="multipart/form-data" role="form">
			<legend>Mission Details</legend>
			<div class="form-group">
				<label for="missionname" class="col-sm-2">Mission Name</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="missionname" id="missionname" placeholder="CO20 - My Mission" required>
				</div>
				<label for="author" class="col-sm-2">Author</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="author" id="author" placeholder="Gibfender" required>
				</div>
			</div>
			<div class="form-group">
				<label for="minplayers" class="col-sm-2">Minimum Players</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="minplayers" id="minplayers" placeholder="8">
				</div>
        <label for="maxplayers" class="col-sm-2">Maximum Players</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="maxplayers" id="maxplayers" placeholder="20">
        </div>
      </div>
        <div class="form-group">
				<label for="terrain" class="col-sm-2">Map</label>
				<div class="col-sm-4">
					<select class="form-control" name="terrain" id="terrain">
						<option>Altis</option>
						<option>Stratis</option>
						<option>Virtual Reality</option>
						<option>Tanoa</option>
            <option>Bukovina</option>
            <option>Bystrica</option>
            <option>Chernarus</option>
            <option>Chernarus Summer</option>
            <option>Desert</option>
            <option>Porto</option>
            <option>Proving Grounds</option>
            <option>Rahmadi</option>
            <option>Sahrani</option>
            <option>Shapur</option>
            <option>Southern Sahrani</option>
            <option>Takistan</option>
            <option>Takistan Mountains</option>
            <option>United Sahrani</option>
            <option>Utes</option>
            <option>Zargabad</option>
            <option>Abramia</option>
            <option>VT5</option>
					</select>
				</div>
        <label for="gamemode" class="col-sm-2">Game Mode</label>
        <div class="col-sm-4">
          <select class="form-control" name="gamemode" is="gamemode">
            <option>Undefined</option>
            <option>Deathmatch</option>
            <option>Capture The Flag</option>
            <option>Cooperative Scenario</option>
            <option>Capture The Island</option>
            <option>Sector Control</option>
            <option>Team Deathmatch</option>
            <option>Role-Playing Game</option>
            <option>Sandbox</option>
            <option>Zeus</option>
            <option>End Game</option>
            <option>Support</option>
            <option>King Of The Hill</option>
            <option>Last Man Standing</option>
            <option>Survival</option>
          </select>
        </div>
			</div>
      <div class="form-group">
        <label for="description" class="col-sm-2">Description</label>
        <div class="col-sm-10">
          <input type="textarea" rows="8" cols="50" class="form-control" name="description" id="description" placeholder="Russian marine assault on British-held town.">
        </div>
      </div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-warning" name="submit" id="submit">Next</button>
				</div>
			</div>
		</form>
	</div>


<?php
	 if (isset($_POST['Submit'])) {
	 $_SESSION['missionname'] = $_POST['missionname'];
	 $_SESSION['author'] = $_POST['author'];
	 $_SESSION['minplayers'] = $_POST['minplayers'];
	 $_SESSION['maxplayers'] = $_POST['maxplayers'];
	 $_SESSION['terrain'] = $_POST['terrain'];
	 $_SESSION['gamemode'] = $_POST['gamemode'];
	 $_SESSION['description'] = $_POST['description'];
	 }
	?>
</body>

</html>
