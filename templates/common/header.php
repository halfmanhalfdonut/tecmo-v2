<header id="header">
	<ul class="menu">
<?php
	if ($_SESSION['loggedIn'] == true) {
?>
		<li><a href="/tecmo/user/logout">Log out</a></li>
<?php
	} else {
?>
		<li><a href="/tecmo/user/register">Register</a></li>
		<li><a href="/tecmo/user/login">Log in</a></li>
<?php
	}
?>
	</ul>
</header>