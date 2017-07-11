<?php require '../settings.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/res/images/favicon.ico">
  	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  	<title><?php echo "$groupname"; ?> Missions</title>

    <script>
    $.get("res/nav.php", function(data){
        $("#nav-placeholder").replaceWith(data);
    });
    </script>
</head>

<body>
	<div id="nav-placeholder"></div>

	<div class="container">
		<form class="form-horizontal" id="mission_meta" action="upload.php" method="post"  enctype="multipart/form-data" role="form">
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
						<option selected="selected">Altis</option>
            <option>Bukovina</option>
            <option>Bystrica</option>
            <option>Chernarus</option>
            <option>Desert Island</option>
            <option>Desert</option>
            <option>Dingor</option>
            <option>Everon</option>
            <option>Isla Abramia</option>
            <option>Kerama Islands</option>
            <option>Kolgujev</option>
            <option>Malden</option>
            <option>Nogova</option>
            <option>Lingor</option>
            <option>Porto</option>
            <option>Proving Grounds</option>
            <option>Rahmadi</option>
            <option>Sahrani</option>
            <option>Shapur</option>
            <option>Southern Sahrani</option>
            <option>Stratis</option>
            <option>Summer Chernarus</option>
            <option>Takistan Mountains</option>
            <option>Takistan</option>
            <option>Tanoa</option>
            <option>United Sahrani</option>
            <option>Utes</option>
            <option>Virtual Reality</option>
            <option>Vt5 - Suomi Finland</option>
            <option>Zargabad</option>
					</select>
				</div>
        <label for="gamemode" class="col-sm-2">Game Mode</label>
        <div class="col-sm-4">
          <select class="form-control" name="gamemode" is="gamemode">
            <option>Undefined</option>
            <option>Deathmatch</option>
            <option>Capture The Flag</option>
            <option selected="selected">Cooperative Scenario</option>
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
      <legend>Select File</legend>
      <div class="form-group">
        <label for="file">Select a file to upload</label>
        <div class="col-sm-10">
          <input type="file" name="file" required>
        </div>
				<div class="btn-group">
          <hr/>
          <a class="btn btn-info" href="index.php" name="back" id="back">Back</a>
					<button type="submit" class="btn btn-warning" name="submit" id="submit">Upload</button>
				</div>
			</div>
		</form>
	</div>
</body>

</html>
