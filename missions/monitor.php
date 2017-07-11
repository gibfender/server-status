<?php require_once("../settings.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/res/images/favicon.ico">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

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

	<div class='server-data'>
		<img src="res/images/smith.png" class="img-fluid center-block image" alt="gooons" width="300" height="300">
	</div>

</body>

</html>
