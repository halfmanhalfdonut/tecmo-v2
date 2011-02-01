<?php
	session_start();
	error_reporting(E_ALL);
	define('SITE_PATH', realpath(dirname(__FILE__)));
	$env = preg_match('/^local/', $_SERVER['SERVER_NAME']) ? 'http://localhost/tecmo' : 'http://' . $_SERVER['SERVER_NAME'] . '/tecmo';
	define('ENV', $env);

	include(SITE_PATH . '/app/bootstrap.php');
	$registry->router = new Router($registry);
	$registry->view = new DefaultView($registry);
	$registry->router->setPath(SITE_PATH . '/controllers/');
	$registry->router->load();
?>