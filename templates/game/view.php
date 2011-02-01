<h1>Tecmo Sports News</h1>

<table id="boxscore">
	<tr>
		<td>Team</td>
		<td>Q1</td>
		<td>Q2</td>
		<td>Q3</td>
		<td>Q4</td>
		<td>Final</td>
	</tr>
	<tr>
		<td class="home"><a href="/tecmo/user/<?php echo $users['home']['username']; ?>"><?php echo $gameStats['home_team']; ?></a></td>
		<td><?php echo $gameStats['home_q1_score']; ?></td>
		<td><?php echo $gameStats['home_q2_score']; ?></td>
		<td><?php echo $gameStats['home_q3_score']; ?></td>
		<td><?php echo $gameStats['home_q4_score']; ?></td>
		<td><?php echo $gameStats['home_total_score']; ?></td>
	</tr>
	<tr>
		<td class="away"><a href="/tecmo/user/<?php echo $users['away']['username']; ?>"><?php echo $gameStats['away_team']; ?></a></td>
		<td><?php echo $gameStats['away_q1_score']; ?></td>
		<td><?php echo $gameStats['away_q2_score']; ?></td>
		<td><?php echo $gameStats['away_q3_score']; ?></td>
		<td><?php echo $gameStats['away_q4_score']; ?></td>
		<td><?php echo $gameStats['away_total_score']; ?></td>
	</tr>
</table>

<table id="stats">
	<th align="center">Team Statistics</th>
	<tr>
		<td>&nbsp;</td>
		<td>Runs</td>
		<td>Pass</td>
		<td>1st Down</td>
	</tr>
	<tr>
		<td class="home"><?php echo $gameStats['home_team']; ?></td>
		<td><?php echo $gameStats['home_rush_att'] . " - " . $gameStats['home_rush_yards'];?></td>
		<td><?php echo $gameStats['home_pass_yards']; ?></td>
		<td><?php echo $gameStats['home_first_downs']; ?></td>
	</tr>
	<tr>
		<td class="away"><?php echo $gameStats['away_team']; ?></td>
		<td><?php echo $gameStats['away_rush_att'] . " - " . $gameStats['away_rush_yards'];?></td>
		<td><?php echo $gameStats['away_pass_yards']; ?></td>
		<td><?php echo $gameStats['away_first_downs']; ?></td>
	</tr>
</table>

<table id="leaders">
	<th align="center">Team Leader</th>
	<tr>
		<td align="center" colspan="5">Runs</td>
	</tr>
	<tr>
		<td class="home"><?php echo $gameStats['home_team']; ?></td>
		<td><?php echo $home[1]['name']; ?></td>
		<td colspan="3" align="right"><?php echo $home[1]['rush_att'] . " - " . $home[1]['rush_yards']; ?></td>
	</tr>
	<tr>
		<td class="home"><?php echo $gameStats['away_team']; ?></td>
		<td><?php echo $away[1]['name']; ?></td>
		<td colspan="3" align="right"><?php echo $away[1]['rush_att'] . " - " . $away[1]['rush_yards']; ?></td>
	</tr>
	<tr>
		<td align="center" colspan="5">Pass</td>
	</tr>
	<tr>
		<td class="home"><?php echo $gameStats['home_team']; ?></td>
		<td><?php echo $home[0]['name']; ?></td>
		<td><?php echo $home[0]['pass_percent']; ?>%</td>
		<td><?php echo $home[0]['pass_yards']; ?></td>
		<td><?php echo $home[0]['interceptions']; ?></td>
	</tr>
	<tr>
		<td class="home"><?php echo $gameStats['away_team']; ?></td>
		<td><?php echo $away[0]['name']; ?></td>
		<td><?php echo $away[0]['pass_percent']; ?>%</td>
		<td><?php echo $away[0]['pass_yards']; ?></td>
		<td><?php echo $away[0]['interceptions']; ?></td>
	</tr>
	<tr>
		<td align="center" colspan="5">Receive</td>
	</tr>
	<tr>
		<td class="home"><?php echo $gameStats['home_team']; ?></td>
		<td><?php echo $home[2]['name']; ?></td>
		<td colspan="3" align="right"><?php echo $home[2]['catches'] . ' - ' .$home[2]['rec_yards'] ; ?></td>
	</tr>
	<tr>
		<td class="home"><?php echo $gameStats['away_team']; ?></td>
		<td><?php echo $away[2]['name']; ?></td>
		<td colspan="3" align="right"><?php echo $away[2]['catches'] . ' - ' .$away[2]['rec_yards'] ; ?></td>
	</tr>
</table>