<?php
require_once '../settings.php';
require_once 'db.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <link rel="shortcut icon" href="/res/images/favicon.ico">
      <title>Broken Missions</title>
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
                                  $conn = get_db();
                                  $stmt = $conn->prepare("SELECT `id`, `name`, `author`, `brokentype`, `brokendes` FROM `missions` WHERE `broken` = 1");
                                  $stmt->execute();
                                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
      									<tr>
      										<td><a href="mission?id=<?php echo (int) $row['id']; ?>"><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></a></td>
      									  <td><?php echo htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') ?></td>
      									  <td><?php echo htmlspecialchars($row['brokentype'], ENT_QUOTES, 'UTF-8') ?></td>
      									  <td><?php echo htmlspecialchars($row['brokendes'], ENT_QUOTES, 'UTF-8') ?></td>
      									</tr>
      							<?php }
                              } catch (PDOException $e) {
                                  error_log("brokenmissions.php error: " . $e->getMessage());
                              }
                      ?>
      			</tbody>
      			</table>
          </div>
        </div>
      </div>
    </body>
</html>
