<?php
require_once '../settings.php';
require_once 'db.php';
require_once("query-servers.php"); ?>

<?php
// Call the class, and add your servers.
$gq = \GameQ\GameQ::factory();
$gq->addServers($servers);
$gq->setOption('timeout', 3); //in seconds
$results = $gq->process();
foreach ($results as $key => $server) {
    if ($key == 'SRV1') {
        $numplayers = (int) $server['gq_numplayers'];
        $locked = (($server['gq_mapname'] == '') or ($numplayers > 0)) ? 'False' : 'True';
        if ($numplayers > 0) {
            $unlockable = 'True';
            try {
                $conn = get_db();
                $stmt = $conn->prepare("SELECT `name` FROM `missions` WHERE (`minplayers` <= ?) AND (`maxplayers` >= ?) AND (`broken` = 0)");
                $stmt->execute([$numplayers, $numplayers]);
                $arr = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $rand_value = !empty($arr) ? $arr[array_rand($arr)] : null;
            } catch (PDOException $e) {
                error_log("index.php suggested mission error: " . $e->getMessage());
                $rand_value = null;
            }
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

        <title><?php echo htmlspecialchars($groupname, ENT_QUOTES, 'UTF-8'); ?> Missions</title>
    </head>

    <body>

        <script>
            $(document).ready(function() {
                $('#live').DataTable({
                    "pageLength": 100,
                    "order": [[7, "desc"]]
                });
                $('#broken').DataTable({
                    "pageLength": 100,
                    "order": [[7, "desc"]]
                });
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
            });
        </script>
        <div id="nav-placeholder"></div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-9">
                    <h1><?php echo htmlspecialchars($groupname, ENT_QUOTES, 'UTF-8'); ?> Mission Management</h1>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-primary" href="addMission" role="button">Upload a mission</a>
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <?php if (!empty($numplayers) && $numplayers > 0 && !empty($rand_value)) { ?>
                    <hr/>
                    <h2>Suggested mission: <?php echo htmlspecialchars($rand_value, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <br/>
                    <p>Suggested missions are selected randomly from missions where the total number of players on the server is greater than the minimum and less than the maximum number of players specified in the mission metadata.</p>
                    <?php } ?>
                </div>
                <div class="col-md-1"></div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active live-tab"><a href="#livemissionstab" aria-controls="livemissionstab" data-toggle="tab" role="tab">Live Missions</a></li>
                        <li class="broken-tab"><a href="#brokenmissionstab" aria-controls="brokenmissionstab" data-toggle="tab" role="tab">Broken Missions</a></li>
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
                                    $conn = get_db();
                                    $stmt = $conn->prepare("SELECT * FROM `missions` WHERE broken = 0");
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><a href="mission?id=<?php echo (int) $row['id']; ?>"><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></a></td>
                                        <td><?php echo htmlspecialchars($row['terrain'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo htmlspecialchars($row['gamemode'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo (int) $row['minplayers'] ?></td>
                                        <td><?php echo (int) $row['maxplayers'] ?></td>
                                        <td><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo htmlspecialchars($row['dateupdated'], ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                    <?php }
                                } catch (PDOException $e) {
                                    error_log("index.php live missions error: " . $e->getMessage());
                                }
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
                                    $conn = get_db();
                                    $stmt = $conn->prepare("SELECT * FROM `missions` WHERE broken = 1");
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><a href="mission?id=<?php echo (int) $row['id']; ?>"><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></a></td>
                                        <td><?php echo htmlspecialchars($row['terrain'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo htmlspecialchars($row['gamemode'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo (int) $row['minplayers'] ?></td>
                                        <td><?php echo (int) $row['maxplayers'] ?></td>
                                        <td><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?php echo htmlspecialchars($row['dateupdated'], ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                    <?php }
                                } catch (PDOException $e) {
                                    error_log("index.php broken missions error: " . $e->getMessage());
                                }
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
