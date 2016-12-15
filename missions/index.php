<?php require 'settings.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="res/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="res/css/custom.css">
	<link rel="shortcut icon" href="/res/images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/r-2.1.0/datatables.min.css"/>
	<script type="text/javascript" src="res/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/r-2.1.0/datatables.min.js"></script>



	<script>
		$.get("res/nav.html", function(data) {
			$("#nav-placeholder").replaceWith(data);
		});
	</script>
	<title><?php echo "$groupname"; ?> Missions</title>
</head>

<body>

<script>
$(document).ready(function() {
    $('#livemissions').DataTable( {
        "order": [[ 5, "desc" ]]
    } );
} );
</script>
<div id="nav-placeholder"></div>
<div class="container">
  <div class="row">
		<div class="col-md-10">
			<h2>Live Missions</h2>
		</div>
		<div class="col-md-2">
			<a class="btn btn-primary" href="addMission.php" role="button">Upload a mission</a>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<table id='livemissions' class='table display'>
				<thead>
					<!--<th>Filename</th>
					<th>ID</th>-->
					<th>Mission Name</th>
					<th>Map</th>
					<th>Author</th>
					<th>Game Mode</th>
					<th>Min. Players</th>
					<th>Max. Players</th>
					<th>Description</th>
					<th>Report</th>
				</thead>
				<tbody>
					<?php
						try {
									$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt = $conn->prepare("SELECT `filename`, `id`, `name`, `terrain`, `author`, `gamemode`, `minplayers`, `maxplayers`, `description`, `broken` FROM `missions` WHERE `broken`='0'");
									$stmt->execute();
									$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
								while($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) { ?>
									<tr>
										<!--<td><?php echo $row['filename'] ?></td>
										<td><?php echo $row['id'] ?></td>-->
									  <td><a href="<?php echo "http://srv1missions.armagoons.com/".$row['filename'] ?>"><?php echo $row['name'] ?></a></td>
									  <td><?php echo $row['terrain'] ?></td>
									  <td><?php echo $row['author'] ?></td>
									  <td><?php echo $row['gamemode'] ?></td>
									  <td><?php echo $row['minplayers'] ?></td>
									  <td><?php echo $row['maxplayers'] ?></td>
									  <td><?php echo $row['description'] ?></td>
										<td><button type="button" name="btn-broken" class="btn btn-danger btn-sm btn-broken" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>">Mark as Broken</button></td>
									</tr>
							<?php }
						}
						catch (PDOException $e) {
										echo "Error: " . $e->getMessage();
						}

						$conn = null;
				?>
			</tbody>
			</table>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#brokenmissions').DataTable( {
        "order": [[ 5, "desc" ]]
    } );
} );
</script>
<div class="container">
  <div class="row">
		<div class="col-md-12">
			<h2>Broken Missions</h2>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<table id="brokenmissions" class='table'>
				<thead>
					<!--<th>Filename</th>
					<th>ID</th>-->
					<th>Mission Name</th>
					<th>Map</th>
					<th>Author</th>
					<th>Game Mode</th>
					<th>Min. Players</th>
					<th>Max. Players</th>
					<th>Description</th>
					<th>Report</th>
				</thead>
				<tbody>
					<?php
						try {
									$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt = $conn->prepare("SELECT `filename`, `id`, `name`, `terrain`, `author`, `gamemode`, `minplayers`, `maxplayers`, `description` FROM `missions` WHERE `broken`='1'");
									$stmt->execute();
									$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
								while($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) { ?>
									<tr>
										<!--<td><?php echo $row['filename'] ?></td>
										<td><?php echo $row['id'] ?></td>-->
									  <td><?php echo $row['name'] ?></td>
									  <td><?php echo $row['terrain'] ?></td>
									  <td><?php echo $row['author'] ?></td>
									  <td><?php echo $row['gamemode'] ?></td>
									  <td><?php echo $row['minplayers'] ?></td>
									  <td><?php echo $row['maxplayers'] ?></td>
									  <td><?php echo $row['description'] ?></td>
									  <td><button type="button" name="btn-fixed" class="btn btn-success btn-sm btn-fixed" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>">Mark as Fixed</button></td>
									</tr>
							<?php }
						}
						catch (PDOException $e) {
										echo "Error: " . $e->getMessage();
						}

						$conn = null;
				?>
			</tbody>
			</table>
    </div>
  </div>
</div>

<script type="text/javascript">
$('.btn-broken').click(function(){
    var id = $(this).data('map');
		var filename = $(this).data('filename');
    $.ajax({
     url: 'broken.php',
     type: "POST",
     data: {id: id,
		 				filename: filename
					},
		 success : function(data) {

		location.reload();
}
});
});
</script>

<script type="text/javascript">
$('.btn-fixed').click(function(){
    var id = $(this).data('map');
		var filename = $(this).data('filename');
    $.ajax({
     url: 'fixed.php',
     type: "POST",
     data: {id: id,
		 				filename: filename
					},
		 success : function(data) {

		location.reload();
}
});
});
</script>
 </body>
 </html>
