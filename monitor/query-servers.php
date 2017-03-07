<?php
require_once( "../settings.php");
require_once("res/gameq/src/GameQ/Autoloader.php");


function secondsToString($seconds) {
	$hours = floor($seconds / 3600);
	$mins = floor($seconds / 60 % 60);
	$secs = floor($seconds % 60);

	return $hours.":".$mins.":".$secs;
}?>


<?php if (isset($_POST['query-servers']) && $_POST['query-servers'] == true){

	// Call the class, and add your servers.
	$gq = \GameQ\GameQ::factory();
	$gq->addServers($servers);

	// You can optionally specify some settings
	$gq->setOption('timeout', 3); //in seconds

	// Send requests, and parse the data
	$results = $gq->process();

?>


	<?php foreach ($results as $key => $server)	{ if ($server['gq_online'])	{ ?>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					Server name: <?php echo $server['gq_hostname'];?>
				</div>
				<div class="col-md-6">
					<?php echo "Mission: " . $server['game_descr']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?php echo "Address: " . $server['gq_address'] . ":" . $server['port']; ?>
				</div>
				<div class="col-md-6">
					<?php echo "Map: " . $server['gq_mapname']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">Mods:
					<a href=# data-toggle="modal" data-target="#modsModal<?php echo $key; ?>">Click to see server mods</a>
          <div class="modal fade" id="modsModal<?php echo $key; ?>" role="dialog">
				    <div class="modal-dialog">
				      <div class="modal-content">
				          <div class="modal-header">
				            <button type="button" class="close" data-dismiss="modal"></button>
				            <h4 class="modal-title">Server mods</h4>
				        	</div>
				          <div class='modal-body'>
										<?php if (isset($server['mods'])) {
											$mods = "";
											foreach ($server['mods'] as $mod) {
												if ($mods == "") {
													$mods = $mod['name'];
												} else {
													$mods = $mods . ",<br> " . $mod['name'];
												}
											}
											echo "<div class='hide-mods'>" . $mods  . "</div>\n";
										} else {
											echo "<div class='hide-mods'>No Mods</div>\n";
										} ?>
					        </div>
					        <div class='modal-footer'>
					          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					        </div>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="col-md-6">	 Players: <?php if ($server['gq_numplayers'] == 0) {
					echo "Server empty";
				} else { ?>
					<a href=# data-toggle="modal" data-target="#playerModal<?php echo $key; ?>">
					<?php echo $server['gq_numplayers'] . "/" . $server['gq_maxplayers']; ?>
					</a>
					<div class="modal fade" id="playerModal<?php echo $key; ?>" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"></button>
										<h4 class="modal-title">Current Players</h4>
									</div>
									<div class='modal-body'>
										<table class="table">
											<thead>
												<tr>
													<th>Player</th>
													<th>Score</th>
													<th>Time Played</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($server['players'] as $player)
							{
								echo "<tr>\n";
									echo "<td>".$player['gq_name']."</td>\n";
									echo "<td>".$player['gq_score']."</td>\n";
									echo "<td>".secondsToString($player['gq_time'])."</td>\n";
								echo "</tr>\n";
							} ?>
											</tbody>
										</table>
									</div>
									<div class='modal-footer'>
										<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
									</div>
							</div>
						</div>
					</div>
				<?php }	?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?php echo "RPT: <a href='http://". $key . "rpt.". $groupsite . "'>Click to see server RPT</a>" ?>
				</div>
			</div>
		</div>
		<hr/>

		<?php }
			else 	{
		?>
			<div class="container">
				<p class="text-danger">The server <?php echo $key ?> is down.</p>
			</div>
			<hr/>
		<?php
						}
					} ?>


	<?php exit(); ?>
<?php } ?>
