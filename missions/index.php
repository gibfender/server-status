<?php
require_once '../settings.php';
require_once( "query-servers.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="/res/images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="res/DataTables/datatables.min.css"/>
	<link href="res/css/bootstrap.min.css" rel="stylesheet">

	<script src="res/js/jquery-3.1.1.min.js"></script>
	<script src="res/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="res/DataTables/datatables.min.js"></script>



	<script>
		$(document).ready(function() {

			var datastring = 'query-servers=true';
			$.ajax({
				type: "POST",
				url: "query-servers.php",
				data: datastring,
				success: function(data) {
					$('.server-data').show().html(data);
				}
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
				if ($key == 'SRV1') {
					if ($server['gq_mapname'] == '') {
						$locked = 'False';
					} else {
						$locked = 'True';
					};
					if ($server['gq_numplayers'] > '0') {
						$unlockable = 'True';
					} else {
						$unlockable = 'False';
					}
				}
				}

			 ?>


			<h4>Server locked: <?php echo $locked ?> </h4>
			<?php if ($fd_enabled == 'True') {
				echo "<button name='btn-unlock' class='btn btn-success btn-unlock'";
				if ($unlockable == 'True') {echo "disabled title='Cannot unlock as there are players connected.'";};
				echo ">Unlock</button>";
			} ?>
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
					<th>test</th>
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
											<button type="button" name="btn-broken-modal" class="btn btn-warning btn-sm" <?php if ($locked == 'True') {echo "disabled";} ?> disabled data-toggle="modal" data-id="<?php echo($row['id']); ?>" title="Report as broken"><span class="glyphicon glyphicon-warning-sign"></span></button>
											<button type="button" name="btn-update-modal" class="btn btn-info btn-sm btn-update-modal" <?php if ($locked == 'True') {echo "disabled";} ?> disabled data-toggle="modal" data-target="#update-modal" title="Upload new version (WIP)" data-map="<?php echo($row['id']); ?>" data-name="<?php echo($row['name']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-upload"></span></button>
											<button type="button" name="btn-delete-modal" class="btn btn-danger btn-sm btn-delete-modal" <?php if ($locked == 'True') {echo "disabled";} ?> data-toggle="modal" data-target="#delete-modal" title="Delete (WIP)" data-name="<?php echo($row['name']); ?>" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-trash"></span></button>
										</td>
										<td><a href="#myModal" class="btn btn-default btn-small" id="custId" data-toggle="modal" data-id="'.$row['ID'].'">Edit</a></td>
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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Data</h4>
            </div>
            <div class="modal-body">
                <div class="fetched-data">
									<?php echo $row['name'] ?>
								</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	$('#myModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
			$.ajax({
					type : 'post',
					url : 'fetch_record.php', //Here you will fetch records
					data :  'rowid='+ rowid, //Pass $id
					success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
					}
			});
	 });
});
</script>
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
											<button type="button" name="btn-update-modal" class="btn btn-info btn-sm btn-update-modal" <?php if ($locked == 'True') { echo "disabled";} ?> data-toggle="modal" data-target="" title="Upload new version (WIP)" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-upload"></span></button>
											<button type="button" name="btn-delete-modal" class="btn btn-danger btn-sm btn-delete-modal" <?php if ($locked == 'True') { echo "disabled";} ?> data-toggle="modal" data-target="" title="Delete (WIP)" data-map="<?php echo($row['id']); ?>" data-filename="<?php echo($row['filename']); ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
$('.btn-unlock').click(function(){

	var user = "<?php echo "$fd_user" ?>";
	var pass = "<?php echo "$fd_pass" ?>";
	var url = "<?php echo "$fd_URL" ?>";

	$.ajax({
		url: url+"/login",
		type: "POST",
		data: {
			username: user,
			password: pass
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
