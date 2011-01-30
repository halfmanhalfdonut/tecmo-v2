<?php
	require_once(SITE_PATH . '/adodb5/adodb.inc.php');
	 // autoload classes
	 function __autoload($className) {
		 $fileName = $className . '.php';
		 $dirs = array('/models/', '/controllers/', '/views/', '/utilities/');
		 foreach ($dirs as $dir) {
			$file = SITE_PATH . $dir . $fileName;
			if (file_exists($file)) break;
		 }
		//echo "Loading " . $file . "<br />";
		 require_once($file);
	 }

	$registry = new Registry();
	 
	$server = 'localhost';
	$user = 'beastmode';
	$password = 't3cm0admin';
	$database = 'tecmo';
	
	$registry->db = ADONewConnection('mysqli');
	$registry->db->Connect($server, $user, $password, $database);
	//$registry->db->debug = true;
?>