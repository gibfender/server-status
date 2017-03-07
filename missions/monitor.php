<?php require_once( "../settings.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="res/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="res/css/custom.css">
	<script type="text/javascript" src="res/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="res/js/jquery-2.1.4.min.js"></script>
	<link rel="shortcut icon" href="res/images/favicon.ico">

	<title><?php echo "$groupname";?> Server Status</title>

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
		$.get("res/nav.php", function(data) {
			$("#nav-placeholder").replaceWith(data);
		});
	</script>
</head>

<body>
	<div id="nav-placeholder"></div>

	<div style="text-align: center;" class="container-fluid">
		<h2><?php echo "$groupname";?> Server Status</h2>
		<hr/>
	</div>

	<script src="res/js/bootstrap.min.js"></script>
	<div class='server-data'>
		<img src="res/images/smith.png" class="img-fluid center-block image" alt="gooons" width="300" height="300">
	</div>

</body>

</html>
