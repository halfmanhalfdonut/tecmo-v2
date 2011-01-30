<?php
	abstract class BaseView {
		protected $registry;
		public $vars;

		public function __construct($registry = false) {
			if ($registry) $this->registry = $registry;
		}

		public function __set($key, $value) {
			$this->vars[$key] = $value;
		}

		public function __get($key) {
			return $this->vars[$key];
		}

		abstract function render($name);
	}
?>