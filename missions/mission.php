<?php
require_once '../settings.php';
require_once 'query-servers.php';

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
        } else {
            $unlockable = 'False';
        }
    }
}
   $id = $_GET['id'];
     try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $stmt = $conn->prepare("SELECT * FROM `missions` WHERE `id`=$id");
         $stmt->execute();
         $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
         while ($row = $stmt->fetch(/* PDO::FETCH_ASSOC */)) {
             $filename = $row['filename'];
             $name = $row['name'];
             $terrain = $row['terrain'];
             $version = $row['version'];
             $author = $row['author'];
             $gamemode = $row['gamemode'];
             $minplayers = $row['minplayers'];
             $maxplayers = $row['maxplayers'];
             $description = $row['description'];
             $SQLdateupdated = $row['dateupdated'];
             $dateupdated = strtotime($SQLdateupdated);
             $SQLdatecreated = $row['datecreated'];
             $datecreated = strtotime($SQLdatecreated);
             $brokentype = $row['brokentype'];
             $brokendes = $row['brokendes'];
             $broken = $row['broken']; ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <link rel="shortcut icon" href="/res/images/favicon.ico">
      <title><?php echo $name; ?></title>
      <link href="res/css/bootstrap.min.css" rel="stylesheet">
      <script src="res/js/jquery-3.1.1.min.js"></script>
      <script src="https://cloud.tinymce.com/stable/tinymce.min.js<?php echo $tinyMCEAPI?>"></script>
      <script>tinymce.init({
        selector: 'textarea',
        height: 400,
        branding: false,
        plugins: [
          'advlist autolink lists link charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen',
          'insertdatetime nonbreaking save table contextmenu directionality'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link preview',
        image_advtab: false
       });
       // Prevent bootstrap dialog from blocking focusin
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window").length) {
		e.stopImmediatePropagation();
	}
});

$('#open').click(function() {
	$("#dialog").dialog({
		width: 800,
		modal: true
	});
});
</script>

      <script src="res/js/bootstrap.min.js"></script>
      <!-- Bootstrap Date-Picker Plugin -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
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
         $.get("res/nav.php", function(data){
             $("#nav-placeholder").replaceWith(data);
         });
      </script>
   </head>
   <body>
      <div id="nav-placeholder"></div>
      <div class="container">
         <div class="well">
            <div class="row">
               <div class="col-md-8">
                  <h1><?php echo $name?></h1>
               </div>
               <div class="col-md-4 pull-right">
                  <a href="<?php if ($broken=='0') {
                 echo "http://srv1missions.$groupsite/$filename";
             } else {
                 echo "http://broken.$groupsite/$filename";
             } ?>"><button type="button" class="btn btn-primary" name="btn-download"><span class="glyphicon glyphicon-download"></span></button></a>
                  <button type="button" class="btn btn-primary" <?php if ($locked == 'true' && $broken == '0') {
                 echo 'disabled';
             } ?> name="btn-update" data-toggle="modal" data-target="#newversion"><span class="glyphicon glyphicon-upload"></span></button>
                  <button type="button" class="btn btn-primary" name="btn-update-meta" data-toggle="modal" data-target="#update-modal"><span class="glyphicon glyphicon-pencil"></span></button>
                  <?php if ($broken == '0') {
                 echo "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#broken-modal' ".(($locked=="true") ? "disabled" : "")."><span class='glyphicon glyphicon-exclamation-sign'></span></button>";
             } else {
                 echo "<button type='button' class='btn btn-success' data-toggle='modal' data-target='#fixed-modal'><span class='glyphicon glyphicon-ok'></span></button>";
             }; ?>
                  <button type="button" class="btn btn-danger"  <?php if ($locked == 'true' && $broken == '0') {
                 echo 'disabled';
             } ?> data-toggle="modal" data-target="#delete-modal"><span class="glyphicon glyphicon-trash"></span></button>
                  <br/>
                  <?php if ($locked=="true" && $broken == '0') {
                 echo"<small class='text-muted'>As the server is currently active, some functionality has been disabled.</small>";
             } ?>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <h4>Version: <?php if (empty($version)) {
                 echo "N/A";
             } else {
                 echo $version;
             } ?></h4>
               </div>
               <!--<div class="col-md-4 pull-right">
                  <div class="btn-group">
                     <a href="#" class="btn btn-success disabled"><span class="glyphicon glyphicon-thumbs-up"></span> I like this mission</a>
                     <a href="#" class="btn btn-danger disabled"><span class="glyphicon glyphicon-thumbs-down"></span> Needs more work</a>
                  </div>
               </div>-->
            </div>
         </div>
      </div>
      <?php if ($broken == '1') {
                 echo "
        <div class='container'>
          <div class='well'>
            <div class='row'>
              <div class='col-md-8'>
                <h4>This mission is broken due to:</h4>
                <p>$brokentype</p>
                <br/>
                <h4>Description:</h4>
                $brokendes
              </div>
            </div>
          </div>
        </div>";
             } ?>
      <div class="container">
         <div class="well">
           <div class="row">
             <div class="col-md-8">
               <h2>Metadata</h2>
             </div>
           </div>
            <div class="row">
               <div class="col-md-4">
                  <h4>Author: <?php echo $author ?></h4>
               </div>
               <div class="col-md-4">
                  <h4>Game Mode: <?php echo $gamemode ?></h4>
               </div>
               <div class="col-md-4">
                  <h4>Map: <?php echo $terrain ?></h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <h4>Min Players: <?php echo $minplayers ?></h4>
               </div>
               <div class="col-md-4">
                  <h4>Max Players: <?php echo $maxplayers ?></h4>
               </div>
               <div class="col-md-4">
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <h4>First Uploaded: <?php if (empty($datecreated)) {
                 echo "N/A";
             } else {
                 echo date('d/m/Y', $datecreated);
             } ?></h4>
               </div>
               <div class="col-md-4">
                  <h4>Last Updated: <?php echo date('d/m/Y', $dateupdated)?></h4>
               </div>
               <div class="col-md-4">
               </div>
            </div>
            <!--<div class="row">
               <div class="col-md-4">
                  <h4>Times Played: <?php if (empty($row['playcount'])) {
                 echo "N/A";
             } else {
                 echo $row['playcount'];
             } ?></h4>
               </div>
               <div class="col-md-4">
               </div>
            </div>-->
         </div>
      </div>
      <div class="container">
         <div class="well">
            <div class="row">
               <div class="col-lg-12">
                  <h2>Description</h2>
                  <br/>
                  <p><?php echo htmlspecialchars_decode($description) ?></p>
               </div>
            </div>
         </div>
      </div>
      <!-- New Version Modal -->
      <div id="newversion" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Upload new version</h4>
               </div>
               <div class="modal-body">
                  <div class="well">
                     <form class="form-horizontal" action="newversion.php" method="post" enctype="multipart/form-data" novalidate>
                        <div class="form-group">
                           <label for="file" class="control-label">Upload PBO File</label>
                           <input type="file" name="file" class="form-control-file aria-describedby="file-help"" required>
                           <small id="file-help" class="form-text text-muted">Only PBO files are allowed with a maximum filesize of 20MB.</small>
                        </div>
                        <div class="form-group">
                           <label for="version" class="control-label">Version</label>
                           <input type="text" name="version" class="col-sm-4 form-control" value="<?php echo($version); ?>" required>
                        </div>
                        <div class="form-group">
                           <label for="note" class="control-label">Note</label>
                           <textarea id="note" name="note" rows="8" cols="80" required><h4>Added</h4><ul><li>None</li></ul><h4>Changed</h4><ul><li>None</li></ul><h4>Removed</h4><ul><li>None</li></ul></textarea>
                        </div>
                        <div class="form-group">
                           <input type="hidden" name="id" value="<?php echo($id); ?>">
                        </div>
                        <input type="submit" class="btn btn-success" value="Upload new version" />
                     </form>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <?php 
         }
     } catch (PDOException $e) {
             echo "Error: " . $e->getMessage();
         }

         $conn = null;
         ?>
      <div class="container">
         <div class="well">
            <div class="row">
               <div class="col-lg-12">
                  <h2>Release Notes</h2>
               </div>
            </div>
            <?php         $dsn = "mysql:host=$servername;dbname=$dbname;";
               $opt = [
                   PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                  PDO::ATTR_EMULATE_PREPARES   => false
                 ];
               $pdo = new PDO($dsn, $username, $password, $opt);
               $stmt= $pdo->query("SELECT * from releasenotes WHERE id='$id' ORDER BY date desc")->fetchAll();
               if (empty($stmt)) {
                   echo '<div class="container">
                   <div class="row">
                     <div class="col-md"><p>None yet!</p>
                     </div>
                   </div>
                   </div>';
               } else {
                   foreach ($stmt as $row) {
                       echo '<div class="container">
                  <div class="well">
                      <div class="row">
                        <div class="col-md-6">
                          <h4>Version</h4>
                          <p>' . $row['version']. '</p>
                        </div>
                        <div class="col-md-6">
                          <h4>Date</h4>
                          <p>' . $row['date']. '</p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <h3>Changelog</h3>
                          <div class="well">
                          <p>' . $row['note']. '</p>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                    <hr/>';
                   }
               };
                $stmt=null;
               ?>
         </div>
      </div>

<div class="container">
  <div class="well">
    <div class="row">
      <div class="col-md-8">
         <h2>Comments</h2>
      </div>
      <div class="col-md-4">
        <button type="button" class="btn btn-primary-outline" name="addcomment" data-toggle="modal" data-target="#commentModal">Add Comment</button>
      </div>
    </div>
    <?php         $dsn = "mysql:host=$servername;dbname=$dbname;";
       $opt = [
           PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES   => false
         ];
       $pdo = new PDO($dsn, $username, $password, $opt);
       $stmt= $pdo->query("SELECT * from comments WHERE id='$id' ORDER BY date desc")->fetchAll();
       if (empty($stmt)) {
           echo '<div class="container">
           <div class="row">
             <div class="col-md"><p>None yet!</p>
             </div>
           </div>
           </div>';
       } else {
           foreach ($stmt as $row) {
               echo '<div class="container-fluid">
              <div class="well">
              <div class="row">
                <div class="col-md-4">
                  <h4>Version</h4>
                  <p>' . $row['version']. '</p>
                </div>
                <div class="col-md-6">
                  <h4>Date</h4>
                  <p>' . $row['date']. '</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h4>Name</h4>
                  <p>' . $row['name']. '</p>
                  <h4>Comment</h4>
                  <p>' . $row['comment']. '</p>
                </div>
              </div>
              </div>
            </div> ';
           }
       };
        $stmt=null;
       ?>
  </div>
</div>


<!-- AddComment Modal -->
<div id="commentModal" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Comment</h4>
         </div>
         <div class="modal-body">
           <h5>For Version: <?php echo $version ?></h5>
           <div class="well">
           <form class="form-horizontal" id="addComment" action="addComment.php" method="post"  enctype="multipart/form-data" role="form" novalidate>
             <div class="form-group">
               <input type="hidden" name="id" id="id" value="<?php echo($id); ?>" />
               <input type="hidden" name="version" id="version" value="<?php echo($version); ?>" />
               <label for="commenter">Your Name:</label>
               <input type="text" class="form-control" name="commenter" id="commenter" placeholder="Your name">
             </div>
             <div class="form-group">
               <label for="comment">Comment:</label>
               <textarea rows="8" class="form-control" name="comment" id="comment" required></textarea>
               <p class="help-block">Please be as helpful and descriptive as possible.</p>
             </div>
             <input type="submit" class="btn btn-warning" value="Submit Comment" />
           </form>
         </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

      <!-- Update Metadata Modal -->
      <div id="update-modal" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
            <script>
               $(document).ready(function(){
                 var date_input=$('input[name="datecreated"]'); //our date input has the name "date"
                 var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                 var options={
                   format: 'dd-mm-yyyy',
                   container: container,
                   todayHighlight: true,
                   autoclose: true,
                 };
                 date_input.datepicker(options);
               })
            </script>
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Mission Metadata</h4>
               </div>
               <div class="modal-body">
                  <div class="well">
                     <form class="form-horizontal" id="mission_meta" action="update.php" method="post"  enctype="multipart/form-data" role="form">
                        <div class="form-group">
                           <label for="missionname" class="col-sm-2">Mission Name</label>
                           <div class="col-sm-4">
                              <input type="hidden" name="id" id="id" value="<?php echo($id); ?>" />
                              <input type="text" class="form-control" name="missionname" id="missionname" value="<?php echo(htmlspecialchars($name));?>" required>
                           </div>
                           <label for="author" class="col-sm-2">Author</label>
                           <div class="col-sm-4">
                              <input type="text" class="form-control" name="author" id="author" value="<?php echo $author ?>" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <!-- Date input -->
                           <label class="col-sm-2" for="datecreated">First Uploaded</label>
                           <div class="col-sm-4">
                              <input class="form-control" id="date" name="datecreated" id="datecreated" <?php if (!empty($datecreated)) {
           echo 'value="' .date('d/m/Y', $datecreated);
           '"';
       } ?> type="text" required />
                           </div>
                           <label for="version" class="col-sm-2">Version</label>
                           <div class="col-sm-4">
                              <input type="text" class="form-control" name="version" id="version" value="<?php echo $version ?>" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="minplayers" class="col-sm-2">Minimum Players</label>
                           <div class="col-sm-4">
                              <input type="text" class="form-control" name="minplayers" id="minplayers" value="<?php echo $minplayers ?>" required>
                           </div>
                           <label for="maxplayers" class="col-sm-2">Maximum Players</label>
                           <div class="col-sm-4">
                              <input type="text" class="form-control" name="maxplayers" id="maxplayers" value="<?php echo $maxplayers ?>" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="terrain" class="col-sm-2">Map</label>
                           <div class="col-sm-4">
                              <select class="form-control" name="terrain" id="terrain" required>
                                 <option selected="selected"><?php echo $terrain; ?></option>
                                 <
                                 <option> Altis</option>
                                 <option>Bukovina</option>
                                 <option>Bystrica</option>
                                 <option>Chernarus</option>
                                 <option>Desert Island</option>
                                 <option>Desert</option>
                                 <option>Dingor</option>
                                 <option>Everon</option>
                                 <option>Isla Abramia</option>
                                 <option>Kerama Islands</option>
                                 <option>Kolgujev</option>
                                 <option>Malden</option>
                                 <option>Nogova</option>
                                 <option>Lingor</option>
                                 <option>Porto</option>
                                 <option>Proving Grounds</option>
                                 <option>Rahmadi</option>
                                 <option>Sahrani</option>
                                 <option>Shapur</option>
                                 <option>Southern Sahrani</option>
                                 <option>Stratis</option>
                                 <option>Summer Chernarus</option>
                                 <option>Takistan Mountains</option>
                                 <option>Takistan</option>
                                 <option>Tanoa</option>
                                 <option>United Sahrani</option>
                                 <option>Utes</option>
                                 <option>Virtual Reality</option>
                                 <option>Vt5 - Suomi Finland</option>
                                 <option>Zargabad</option>
                              </select>
                           </div>
                           <label for="gamemode" class="col-sm-2">Game Mode</label>
                           <div class="col-sm-4">
                              <select class="form-control" name="gamemode" is="gamemode" required>
                                 <option selected="selected"><?php echo $gamemode ?></option>
                                 <option>Undefined</option>
                                 <option>Deathmatch</option>
                                 <option>Capture The Flag</option>
                                 <option>Cooperative Scenario</option>
                                 <option>Capture The Island</option>
                                 <option>Sector Control</option>
                                 <option>Team Deathmatch</option>
                                 <option>Role-Playing Game</option>
                                 <option>Sandbox</option>
                                 <option>Zeus</option>
                                 <option>End Game</option>
                                 <option>Support</option>
                                 <option>King Of The Hill</option>
                                 <option>Last Man Standing</option>
                                 <option>Survival</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="description" class="col-sm-2">Description</label>
                           <div class="col-sm-10">
                              <textarea rows="8" class="form-control" name="description" id="description" required><?php echo $description ?></textarea>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-warning" name="submit" id="submit">Save Changes</button>
                     </form>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>


      <!-- Mark as fixed Modal -->
      <div id="fixed-modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Mark this mission as fixed?</h4>
               </div>
               <div class="modal-body">
                  <div class="well">
                     <p>Is this mission now fixed?</p>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-fixed" name="btn-fixed" data-id="<?php echo $id; ?>" data-filename="<?php echo $filename; ?>" data-dismiss="modal">Mark as fixed</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         $('.btn-fixed').click(function(){
             var id = $(this).data('id');
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


      <!-- Mark as broken Modal -->
      <div id="broken-modal" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Mark this mission as broken?</h4>
               </div>
               <div class="modal-body">
                  <div class="well">
                     <form class="form-horizontal" action="broken.php" method="post"  enctype="multipart/form-data" role="form" novalidate>
                        <div class="form-group">
                           <label for="brokentype" class="col-sm-2">Broken Category</label>
                           <div class="col-sm-8">
                              <input type="hidden" name="id" value="<?php echo($id); ?>" />
                              <input type="hidden" name="filename" value="<?php echo($filename); ?>" />
                              <select class="form-control" name="brokentype" is="brokentype">
                                 <option selected="selected">No Slots/Doesn't Load</option>
                                 <option>Script Error</option>
                                 <option>Missing/Empty Gear</option>
                                 <option>JIP/Respawn Issues</option>
                                 <option>3rd person enabled on TvT</option>
                                 <option>Spectator issues</option>
                                 <option>Missing Dependencies</option>
                                 <option >Radio/Comms Issue</option>
                                 <option>Other</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="brokendes" class="col-sm-2">Additional Comments</label>
                           <div class="col-sm-8">
                              <textarea class="form-control" rows="5" name="brokendes" placeholder="What exactly was broken? Please be as specific as possible." required></textarea>
                           </div>
                        </div>
                        <p>Please only mark missions as broken if they are unplayable in their current state. Suggestions or comments should be directed to the missionmaker in the comments.</p>
                  </div>
                  <div class="modal-footer">
                  <input type="submit" class="btn btn-warning" value="Mark as broken" />
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>



      <!-- Delete Modal -->
      <div id="delete-modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Delete Mission</h4>
               </div>
               <div class="modal-body">
                 <form class="" action="delete.php" method="post">
                   <input type="hidden" name="id" value="<?php echo($id); ?>" />
                   <input type="hidden" name="filename" value="<?php echo($filename); ?>" />
                    <p>Are you sure you want to remove this mission from the server and database?</p>


               </div>
               <div class="modal-footer">
                 <input type="submit" class="btn btn-danger" value="Delete Mission" />
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </form>
               </div>
            </div>
         </div>
      </div>


   </body>
</html>
