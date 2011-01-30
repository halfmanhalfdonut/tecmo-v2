<?php
	class DefaultView extends BaseView {
		public function render($name) {
			$path = SITE_PATH . '/templates/' . $name . '.php';

			if (!file_exists($path)) {
				throw new Exception('Template not found.');
				return false;
			}

			foreach($this->vars as $key => $value) {
				$$key = $value;
			}

			include $path;
		}
	}
?>