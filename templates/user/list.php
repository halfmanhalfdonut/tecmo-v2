<?php
	if ($showOne) {
?>	
<h1>Stats for <?php echo $username; ?></h1>
<?php foreach($games as $game) { 
	echo $game['home_team'];
 } ?>
<?php } else { ?>
<h1>Tecmo Players</h1>
<ul class="players">
<?php foreach($users as $user) {
?>
	<li><a href="/tecmo/user/<?php echo $user['username']; ?>"><?php echo $user['username']; ?></a></li>
<?php } ?>
</ul>
<?php } ?>