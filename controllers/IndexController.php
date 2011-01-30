<?php
	class IndexController extends BaseController {
		public function index() {
			$this->view->title = "Tecmo Fever";
			$this->view->welcome = "Welcome to my balls";
		}
	}
?>