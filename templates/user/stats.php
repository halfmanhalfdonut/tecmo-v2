<h1>Stats for <?php echo $username; ?></h1>

<table id="stats">
	<th>User Stats</th>
	<tr>
		<td colspan="5" align="center">Most Played Team</td>
	</tr>
	<tr>
		<td colspan="5"><?php echo $mostUsedTeam; ?></td>
	</tr>
	<tr>
		<td colspan="5" align="center">Biggest Rival</td>
	</tr>
	<tr>
		<td colspan="5"><a href="/tecmo/user/<?php echo $rival; ?>"><?php echo $rival; ?></a></td>
	</tr>
	<tr>
		<td colspan="5" align="center">Average Scoring</td>
	</tr>
	<tr>
		<td>1st Qtr</td>
		<td>2nd Qtr</td>
		<td>3rd Qtr</td>
		<td>4th Qtr</td>
		<td>Total</td>
	</tr>
	<tr>
		<td><?php echo number_format($totals['q1']/$div, 2); ?></td>
		<td><?php echo number_format($totals['q2']/$div, 2); ?></td>
		<td><?php echo number_format($totals['q3']/$div, 2); ?></td>
		<td><?php echo number_format($totals['q4']/$div, 2); ?></td>
		<td><?php echo number_format($totals['total']/$div, 2); ?></td>
	</tr>
	<tr>
		<td colspan="5" align="center">Rush</td>
	</tr>
	<tr>
		<td>Attempts per Game</td>
		<td>Total Attempts</td>
		<td colspan="2">Yards per Game</td>
		<td>Total Yards</td>
	</tr>
	<tr>
		<td><?php echo number_format($totals['rush_att'] / $div, 2); ?></td>
		<td><?php echo $totals['rush_att']; ?></td>
		<td colspan="2"><?php echo number_format($totals['rush_yards'] / $div, 2); ?></td>
		<td><?php echo $totals['rush_yards']; ?></td>
	</tr>
	<tr>
		<td colspan="5" align="center">Pass</td>
	</tr>
	<tr>
		<td colspan="2">Yards per Game</td>
		<td colspan="3">Total Yards</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo number_format($totals['pass_yards']/$div, 2); ?></td>
		<td colspan="3"><?php echo $totals['pass_yards']; ?></td>
	</tr>
</table>