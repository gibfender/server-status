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
      <script src="res/js/jquery-3.1.1.min.js"></script>
      <script src="res/js/bootstrap.min.js"></script>
      <script>
         $.get("res/nav.php", function(data){
             $("#nav-placeholder").replaceWith(data);
         });
      </script>
   </head>
   <body>
      <div id="nav-placeholder"></div>
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <h1>TVT6-24 Murder Simulator Rework</h1>
            </div>
         </div>
         <hr/>
         <div class="row">
            <div class="col-md-6">
               <h4>Version: 1.6</h4>
            </div>
            <div class="col align-self-end">
               <div class="btn-group">
                  <button type="button" class="btn btn-success" name="btn-download">Download</button>
                  <button type="button" class="btn" name="btn-update">Upload new version</button>
                  <button type="button" class="btn" name="btn-update-meta">Update Metadata</button>
                  <button type="button" class="btn btn-warning" name="btn-broken">Flag as broken</button>
                  <button type="button" class="btn btn-danger" name="btn-delete">Delete</button>
               </div>
            </div>
         </div>
         <hr/>
         <div class="row">
            <div class="col-md-4">
               <h4>Author: Doctor Butts</h4>
            </div>
            <div class="col-md-4">
               <h4>Game Mode: Team Deathmatch</h4>
            </div>
            <div class="col-md-4">
               <h4>Map: Altis</h4>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <h4>Min Players: 6</h4>
            </div>
            <div class="col-md-4">
               <h4>Max Players: 24</h4>
            </div>
            <div class="col-md-4">
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <h4>First Uploaded: 03/05/2017</h4>
            </div>
            <div class="col-md-4">
               <h4>Last Updated: 07/05/2017</h4>
            </div>
            <div class="col-md-4">
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <h4>Times Played: 0</h4>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
              <div class="btn-group">
                 <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> I like this mission</a>
                 <a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down"></span> Needs more work</a>
              </div>
            </div>
         </div>
         <hr/>
         <div class="row">
            <div class="col-lg-12">
               <h4>Description</h4>
               <br/>
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean a elit viverra, vulputate enim a, ornare eros. Nullam tempor dolor eget mi iaculis, et tristique sem aliquam. Sed tempus enim nec nibh scelerisque lobortis. Mauris id consequat lorem. Quisque ornare nec lacus nec iaculis. Ut vehicula mauris vitae felis porta varius. Proin ornare auctor dui, eget fermentum mi suscipit non. Nulla eget risus ac ligula efficitur volutpat. Aliquam non condimentum tellus. Mauris nec erat sed eros condimentum egestas at in erat. In in velit vitae lectus porta elementum. Sed at pretium tortor. Ut quis nisi tempus, malesuada ex quis, feugiat lacus. Aliquam erat volutpat.</p>
            </div>
         </div>
         <hr/>
         <div class="row">
            <div class="col-lg-12">
               <h4>Release Notes</h4>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <h4>v.1.6</h4>
               <br/>
               <ul>
                  <li>First item</li>
                  <li>Second item</li>
                  <li>Third item</li>
               </ul>
            </div>
         </div>
         <hr/>
         <div class="row">
            <div class="col-lg-12">
               <h4>v.1.5</h4>
               <br/>
               <ul>
                  <li>First item</li>
                  <li>Second item</li>
                  <li>Third item</li>
               </ul>
            </div>
         </div>
         <hr/>
      </div>
   </body>
</html>
