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

<fieldset id="login">
	<legend>Login:&nbsp;</legend>
	<form  id="login" name="login" method="POST" action="/tecmo/user/login" onSubmit="return wambo.validate(this);">
		<ul class="labelsInputs">
			<li><input id="username" name="username" />Username:</li>
			<li><input id="password" type="password" name="password" />Password:</li>
		</ul>
		<input type="submit" value="Log in!" class="submit" />
	</form>	
	<a href="/tecmo/user/reset">Forgot your password?</a>
</fieldset>