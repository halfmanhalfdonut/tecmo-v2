<?php
	if (!empty($errors)) {
?>
		<div id="errors" class="error">
<?php
		foreach($errors as $error) {
			echo $error;
		}
?>
		</div>
<?php
	}
?>

<?php if ($success) { ?>
	<div id="sucess" class="success">Successfully uploaded <?php echo $filename; ?>. Make sure it's correct!</div>
	<div id="overview">
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
				<td class="home"><a href="/tecmo/user/<?php echo $homeUser['username'] ?>"><?php echo $stats['home']['team']; ?></a></td>
				<td><?php echo $stats['home']['score']['q1']; ?></td>
				<td><?php echo $stats['home']['score']['q2']; ?></td>
				<td><?php echo $stats['home']['score']['q3']; ?></td>
				<td><?php echo $stats['home']['score']['q4']; ?></td>
				<td><?php echo $stats['home']['score']['total']; ?></td>
			</tr>
			<tr>
				<td class="away"><a href="/tecmo/user/<?php echo $awayUser['username']; ?>"><?php echo $stats['away']['team']; ?></a></td>
				<td><?php echo $stats['away']['score']['q1']; ?></td>
				<td><?php echo $stats['away']['score']['q2']; ?></td>
				<td><?php echo $stats['away']['score']['q3']; ?></td>
				<td><?php echo $stats['away']['score']['q4']; ?></td>
				<td><?php echo $stats['away']['score']['total']; ?></td>
			</tr>
		</table>
		<a href="/tecmo/game/view/<?php echo $gameId; ?>">Game stats</a>
	</div>
<?php } ?>
	
<form id="add" method="POST" action="/tecmo/game/add" enctype="multipart/form-data">	
	<label for"file">Nestopia File (.ns*): </label>		
	<input id="file" type="file" name="file" value="" />
	<input type="hidden" name="MAX_FILE_SIZE" value="20000" />
	<input type="hidden" value="<?php echo $_SESSION['id']; ?>" name="uploader" />
	<select id="opponent" name="opponent">
		<option value="none">Opponent</option>
	<?php foreach($users as $user) {
			if ($user['username'] != $_SESSION['userName']) {
	?>
			<option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
	<?php
			}
	}
	?>
	</select>
	<select id="homeAway" name="homeAway">
		<option value="none">Were you home/away?</option>
		<option value="home">Home</option>
		<option value="away">Away</option>
	</select>
	<input type="submit" value="Upload File">
	</p>
</form>