<?php
	class Router {
		private $registry;
		private $path;
		private $DEFAULT_ACTION = 'index';
		private $DEFAULT_CONTROLLER = 'IndexController';

		public $file;
		public $controller = "";
		public $action = "";
		public $args = array();

		public function __construct($registry) {
			$this->registry = $registry;
		}

		public function setPath($path) {
			if (!is_dir($path)) {
				throw new Exception("Invalid Controller path: " . $path);
			}
			$this->path = $path;
		}

		public function load() {
			$this->getController();

			if (!is_readable($this->file)) {
				echo $this->file;
				die('404 Not Found');
			}

			//require_once($this->file);

			$class = $this->controller;
			$controller =  new $class($this->registry);
			
			if (!is_callable(array($controller, $this->action))) {
				$action = $this->DEFAULT_ACTION;
				$this->args = array_merge((array)$this->action, (array)$this->args);
			} else {
				$action = $this->action;
			}
			if (empty($this->args)) {
				$args = array();
			} else {
				$args = $this->args;
			}
			
			$controller->$action($args);
		}

		private function getController() {
			$route = empty($_GET['q']) ? '' : $_GET['q'];

			if (empty($route)) {
				$route = $this->DEFAULT_CONTROLLER;
			} else {
				$parts = explode('/', $route);
				$this->controller = ucwords($parts[0]. 'Controller');
				if (isset($parts[1])) {
					$this->action = $parts[1];
				}
				$parts = array_slice($parts, 2);
				if (isset($parts[0])) {
					$this->args = $parts;
				}
			}

			if (empty($this->controller)) {
				$this->controller = $this->DEFAULT_CONTROLLER;
			}

			if (empty($this->action)) {
				$this->action = $this->DEFAULT_ACTION;
			}
			
			if (empty($this->args)) {
				$this->args = array();
			}

			$this->file = $this->path . $this->controller . '.php';
		}
	}
?>