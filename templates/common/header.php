<header id="header">
	<ul class="menu">
<?php
	if ($_SESSION['loggedIn'] == true) {
?>
		<li><a href="/tecmo/">Home</a></li>
		<li><a href="/tecmo/user/">User List</a></li>
		<li><a href="/tecmo/game/">Recent Games</a></li>
		<li><a href="/tecmo/game/add">Upload a Game</a></li>
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