<?php
	class Http {
		function __construct(){}
		
		public function redirect($url = false) {
			if ($url) {
				if (preg_match('/^http/', $url)) {
					header("Location: " . $url);
				} else {
					header("Location: " . ENV . $url);
				}
			} else {
				header("Location: " . ENV);
			}
		}
	}
?>