<?php
	abstract class BaseController {
		protected $registry;
		protected $view;
		protected $template = 'home';
		
		public function __construct($registry) {
			$this->registry = $registry;
			$this->view = $registry->view;
		}

		public function __destruct() {
			$vars = $this->view->vars;
			include (SITE_PATH . '/templates/common/head.php');
			include (SITE_PATH . '/templates/common/header.php');
			$this->view->render($this->template);
			include (SITE_PATH . '/templates/common/footer.php');
		}
		
		abstract function index();
	}
?>