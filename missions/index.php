<?php
require_once '../settings.php';
require_once( "../monitor/query-servers.php"); ?>

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
		$(document).ready(function() {

			//use asynchronous AJAX call via JQuery to query the servers in the backend
			//this way it's not blocking the loading of the page
			var datastring = 'query-servers=true';
			$.ajax({
				type: "POST",
				url: "query-servers.php",
				data: datastring,
				success: function(data) {
					//show information in our div
					$('.server-data').show().html(data);

				}
			});

		});
	</script>

	<script>
	$(document).ready(function(){
	    $("#modal").click(function(){
	        $("#myModal").modal();
	    });
	});
	</script>

	<script>
		$.get("res/nav.php", function(data) {
			$("#nav-placeholder").replaceWith(data);
		});
	</script>
	<title><?php echo "$groupname"; ?> Missions</title>
</head>

<body>
<script>
$(document).ready(function() {
    $('#livemissions').DataTable( {
        "order": [[ 7, "desc" ]]
    } );
} );
</script>
<div id="nav-placeholder"></div>

<div class="container">
  <div class="row">
		<div class="col-md-10">
			<h1><?php echo "$groupname";?> Mission Management</h1>

			<?php

			// Call the class, and add your servers.
    $gq = \GameQ\GameQ::factory();
    $gq->addServers($servers);
    // You can optionally specify some settings
    $gq->setOption('timeout', 3); //in seconds
    // Send requests, and parse the data
    $results = $gq->process();

			foreach ($results as $key => $server) {
				if ($server['gq_mapname'] == '') {
					$locked = 'False';
				} else {
					$locked = 'True';
				}
			}
			 ?>


			<h4>Server locked: <?php echo $locked ?> </h4>
		</div>
		<div class="col-md-2">
			<a class="btn btn-primary" href="addMission.php" role="button">Upload a mission</a>
		</div>
	</div>
	<hr/>
	<h2>Live Missions</h2>
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
					<th>Last Updated</th>
					<th>Manage</th>
				</thead>
				<tbody>
					<?php
						try {
									$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt = $conn->prepare("SELECT `filename`, `dateupdated`, `id`, `name`, `terrain`, `author`, `gamemode`, `minplayers`, `maxplayers`, `description`, `broken` FROM `missions` WHERE `broken`='0'");
									$stmt->execute();
									$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
								while($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) { ?>
									<tr>
										<!--<td><?php echo $row['filename'] ?></td>
										<td><?php echo $row['id'] ?></td>-->
										<td><a href="<?php echo "http://srv1missions.$groupsite/".$row['filename'] ?>"><?php echo $row['name'] ?></a></td>
									  <td><?php echo $row['terrain'] ?></td>
									  <td><?php echo $row['author'] ?></td>
									  <td><?php echo $row['gamemode'] ?></td>
									  <td><?php echo $row['minplayers'] ?></td>
									  <td><?php echo $row['maxplayers'] ?></td>
									  <td><?php echo $row['description'] ?></td>
										<td><?php echo $row['dateupdated'] ?></td>
										<td>
											<button type="button" name="btn-broken" class="btn btn-warning btn-sm btn-broken" <?php if ($locked == 'True') {echo "disabled";} ?> data-toggle="" data-target="" title="Report as broken" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-warning-sign"></span></button>
											<button type="button" name="btn-update" class="btn btn-info btn-sm btn-update" <?php if ($locked == 'True') {echo "disabled";} ?> data-toggle="" data-target="" title="Upload new version (WIP)" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-upload"></span></button>
											<button type="button" name="btn-delete" class="btn btn-danger btn-sm btn-delete" <?php if ($locked == 'True') {echo "disabled";} ?> data-toggle="" data-target="" title="Delete (WIP)" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-trash"></span></button>
										</td>
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
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#brokenmissions').DataTable( {

    } );
} );
</script>
<div class="container">
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<h2>Broken Missions</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table id="brokenmissions" class='table'>
				<thead>
						<th>Mission Name</th>
						<th>Author</th>
						<th>Failure Category</th>
						<th>Failure Description</th>
						<th>Report</th>
				</thead>
				<tbody>
					<?php
						try {
									$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt = $conn->prepare("SELECT `filename`, `id`, `name`, `author`, `brokentype`, `brokendes`, `broken` FROM `missions` WHERE `broken`='1'");
									$stmt->execute();
									$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
								while($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) { ?>
									<tr>
										<td><a href="<?php echo "http://broken.$groupsite/".$row['filename'] ?>"><?php echo $row['name'] ?></a></td>
									  <td><?php echo $row['author'] ?></td>
									  <td><?php echo $row['brokentype'] ?></td>
									  <td><?php echo $row['brokendes'] ?></td>
									  <td>
											<button type="button" name="btn-fixed" class="btn btn-success btn-sm btn-fixed" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-ok"></span></button>
											<button type="button" name="btn-update" class="btn btn-info btn-sm btn-update" <?php if ($locked == 'True') { echo "disabled";} ?> data-toggle="" data-target="" title="Upload new version (WIP)" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-upload"></span></button>
											<button type="button" name="btn-delete" class="btn btn-danger btn-sm btn-delete" <?php if ($locked == 'True') { echo "disabled";} ?> data-toggle="" data-target="" title="Delete (WIP)" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-trash"></span></button>
										</td>
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
$('.btn-delete').click(function(){
    var id = $(this).data('map');
		var filename = $(this).data('filename');
    $.ajax({
     url: 'delete.php',
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
