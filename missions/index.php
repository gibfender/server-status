<?php
require_once '../settings.php';
require_once( "query-servers.php"); ?>

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
		$numplayers = $server['gq_numplayers'];
		if (($server['gq_mapname'] == '') or ($numplayers > '0')) {
			$locked = 'False';
		} else {
			$locked = 'True';
		};
		if ($server['gq_numplayers'] > '0') {
			$unlockable = 'True';
			try {
						$missions = array();
						$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $conn->prepare("SELECT `name` FROM `missions` WHERE (`minplayers`<=$numplayers) AND (`maxplayers`>=$numplayers) AND (`broken`='0')");
						$stmt->execute();
						$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
						$arr = $result;
						$rand_key = array_rand($arr);
						$rand_value = $arr[$rand_key];
			}
			catch (PDOException $e) {
							echo "Error: " . $e->getMessage();
			}
			$conn = null;
		} else {
			$unlockable = 'False';
		}
}
}
 ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="/res/images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="res/DataTables/datatables.min.css" />
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

        <title>
            <?php echo "$groupname"; ?> Missions</title>
    </head>

    <body>

        <script>
            $(document).ready(function() {

                $('#live').DataTable({
                    "pageLength": 100,
                    "order": [
                        [7, "desc"]
                    ]
                });
                $('#broken').DataTable({
                    "pageLength": 100,
                    "order": [
                        [7, "desc"]
                    ]
                });

                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                });
            });
        </script>
        <div id="nav-placeholder"></div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-9">
                    <h1><?php echo "$groupname";?> Mission Management</h1>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-primary" href="addMission" role="button">Upload a mission</a>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <?php if ($numplayers> 0) { echo "
                    <hr/>
                    <h2>Suggested mission: ".$rand_value."</h2>
                    <br/>
                    <p>Suggested missions are selected randomly from missions where the total number of players on the server is greater than the minimum and less that the maximum number of players specified in the mission metadata.</p>"; } ?>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active live-tab"><a href="#livemissionstab" aria-controls="livemissionstab" data-toggle="tab" role="tab">Live Missions</a>
                        </li>
                        <li class="broken-tab"><a href="#brokenmissionstab" aria-controls="brokenmissionstab" data-toggle="tab" role="tab">Broken Missions</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="livemissionstab" role="tabpanel" class="tab-pane fade in active">
                            <table id='live' class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <th>Mission Name</th>
                                    <th>Map</th>
                                    <th>Author</th>
                                    <th>Game Mode</th>
                                    <th>Min Players</th>
                                    <th>Max Players</th>
                                    <th>Description</th>
                                    <th>Last Updated</th>
                                </thead>
                                <tbody>
																	<?php
																		try {
																					$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
																					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
																					$stmt = $conn->prepare("SELECT * FROM `missions` WHERE broken='0'");
																					$stmt->execute();
																					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
																				while($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) { ?>
                                    <tr>
                                        <td>
                                            <a href="mission?id=<?php echo $row['id']; ?>">
                                                <?php echo $row[ 'name'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'terrain'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'author'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'gamemode'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'minplayers'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'maxplayers'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'description'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'dateupdated'] ?>
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
                        <div id="brokenmissionstab" class="tab-pane fade in" role="tabpanel">
                            <table id='broken' class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <th>Mission Name</th>
                                    <th>Map</th>
                                    <th>Author</th>
                                    <th>Game Mode</th>
                                    <th>Min Players</th>
                                    <th>Max Players</th>
                                    <th>Description</th>
                                    <th>Last Updated</th>
                                </thead>
                                <tbody>
																	<?php
						try {
									$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt = $conn->prepare("SELECT * FROM `missions` WHERE broken='1'");
									$stmt->execute();
									$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
								while($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) { ?>
                                    <tr>
                                        <td>
                                            <a href="mission?id=<?php echo $row['id']; ?>">
                                                <?php echo $row[ 'name'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'terrain'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'author'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'gamemode'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'minplayers'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'maxplayers'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'description'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[ 'dateupdated'] ?>
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

                <div class="col-md-1"></div>
            </div>
        </div>
    </body>

    </html>
