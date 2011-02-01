<h1>Recent Games</h1>
<ul>
<?php foreach($recent as $id => $game) { ?>
	<li><a href="/tecmo/game/view/<?php echo $id; ?>"><?php echo $game['home_team'] . ' ' . $game['home_total_score'] . ' - ' . $game['away_team'] . ' ' . $game['away_total_score']; ?></a></li>
<?php } ?>
</ul>