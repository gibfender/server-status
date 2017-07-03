<?php require_once '../settings.php'; ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!--<meta http-equiv="refresh" content="3" >-->
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <link rel="shortcut icon" href="/res/images/favicon.ico">
      <title>Mission Details: <?php echo $_POST['missionname'];?></title>
      <link href="res/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="res/DataTables/datatables.min.css"/>

      <script src="res/js/jquery-3.1.1.min.js"></script>
      <script src="res/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="res/DataTables/datatables.min.js"></script>

      <script>
         $.get("res/nav.php", function(data){
             $("#nav-placeholder").replaceWith(data);
         });
      </script>
   </head>
   <body>
      <div id="nav-placeholder"></div>

      <script>
      $(document).ready(function() {
          $('#brokenmissions').DataTable( {
            "pageLength": 50
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
      										<td><a href="mission?id=<?php echo $row['id']; ?>"><?php echo $row['name'] ?></a></td>
      									  <td><?php echo $row['author'] ?></td>
      									  <td><?php echo $row['brokentype'] ?></td>
      									  <td><?php echo $row['brokendes'] ?></td>

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
    </body>
