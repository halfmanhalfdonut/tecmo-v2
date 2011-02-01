<?php
	if ($success) {
?>
<div id="success" class="success">Your password will be emailed to <strong><?php echo($email); ?></strong> shortly.</div>
<?php
	} else {
		
		if (!empty($email)) {
?>
			<div id="errors" class="error">There is no user registered with <strong><?php echo($email); ?></strong>.</div>
<?php
		}
?>

<fieldset id="reset">
	<legend>Reset your Password:&nbsp;</legend>
	<form id="createForm" name="createForm" method="POST" action="/tecmo/user/reset" onsubmit="return wambo.validate(this);" >
		<ul class="labelsInputs">
			<li><input id="email" name="email" <?php if (!empty($email)) { echo 'value="'.$email.'"'; } ?> />Email:</li>
		</ul>
		<input type="submit" value="Submit" />
	</form>
</fieldset>
<?php 
	}
?>