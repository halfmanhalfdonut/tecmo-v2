<?php
/**
 * The Registry eliminates the need for global variables by holding all variables in the registry object
 * @author wambotron
 */
	class Registry {
		/**
		 * Associative array holding all the registry items
		 */
		private $vars = array();
		
		/**
		 * @param $key Key
		 * @param  $value Value
		 */
		public function __set($key, $value) {
			$this->vars[$key] = $value;
		}

		/**
		 * @param $key Key to retrieve
		 * @return value from speecified index key
		 */
		public function __get($key) {
			return $this->vars[$key];
		}
	}
?>