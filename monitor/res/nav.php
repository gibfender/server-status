<?php require_once '../../settings.php' ?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://www.<?php echo $groupsite ?>"><?php echo $groupname; ?></a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="http://monitor.<?php echo $groupsite; ?>">Server Monitor</a></li>
      <li><a href="http://missions.<?php echo $groupsite; ?>">Missions</a></li>
      <li><a href="<?php echo $groupdiscord; ?>">Discord</a></li>
    </ul>
  </div>
</nav>
