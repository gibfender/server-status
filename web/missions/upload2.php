<?php require 'settings.php'; ?>
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
		$.get("res/nav.html", function(data) {
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
		<div class="row">
		<form class="form-horizontal" id="file_upload" action="save.php" method="post" enctype="multipart/form-data">
			<legend>Select File</legend>
			<div class="form-group">
				<label for="file">Select a file to upload</label>
				<div class="col-sm-4">
					<input type="file" name="file" required>
				</div>
			</div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-warning" name="submit" id="submit">Submit</button>
        </div>
      </div>
		</form>
	</div>
	</div>

</body>

</html>
