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
  $.get("res/nav.html", function(data){
      $("#nav-placeholder").replaceWith(data);
  });
  </script>
</head>

<body>
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
		<div class="col-md-10">
      <?php
        include_once 'maketable.php';

        $sql = 'SELECT `name`, `terrain`, `author`, `gamemode`, `minplayers`, `maxplayers`, `description`, `broken` FROM `missions` WHERE `broken`="0"';
        try {
            $conn = new PDO( "mysql:host=$servername;dbname=$dbname", "$username", "$password" );
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo maketable(
                $executed_pdo_statement = $conn->query( $sql ),
                $column_headers = array('Mission Name', 'Map', 'Author', 'Game Mode',  'Min. Players', 'Max. Players', 'Description', 'Status'),
                $column_align = array('left', 'left', 'center'),
                $first_indent = "\t\t\t",
                $indent = "\t",
                $id = 'clients-table',
                $class = 'table',
                $style = 'padding: 0px; margin: 0px;'
            );
        } catch( PDOException $e ) {
            echo '<p>DATABASE ERROR:<br/>' . $e->getMessage() . '<br/>SQL query: ' . $sql . '</p>';
        }
        $conn = null;
         ?>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
		<div class="col-md-12">
			<h2>Broken Missions</h2>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-10">
      <?php
        include_once 'maketable.php';

        $sql = 'SELECT `name`, `terrain`, `author`, `gamemode`, `minplayers`, `maxplayers`, `description`, `broken` FROM `missions` WHERE `broken`="1"';
        try {
            $conn = new PDO( "mysql:host=$servername;dbname=$dbname", "$username", "$password" );
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo maketable(
                $executed_pdo_statement = $conn->query( $sql ),
                $column_headers = array('Mission Name', 'Map', 'Author', 'Game Mode',  'Min. Players', 'Max. Players', 'Description', 'Status'),
                $column_align = array('left', 'left', 'center'),
                $first_indent = "\t\t\t",
                $indent = "\t",
                $id = 'clients-table',
                $class = 'table',
                $style = 'padding: 0px; margin: 0px;'
            );
        } catch( PDOException $e ) {
            echo '<p>DATABASE ERROR:<br/>' . $e->getMessage() . '<br/>SQL query: ' . $sql . '</p>';
        }
        $conn = null;
         ?>
    </div>
  </div>
</div>

 </body>
 </html>
