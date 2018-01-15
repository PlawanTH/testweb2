<?php

	namespace App\Controllers;

	use \Core\View;

	class Home extends \Core\Controller {

		public function __call($name, $args) {

			$method = $name . "Action";
			if ( method_exists($this, $method) ) {
				if ($this->before() !== false) {
					call_user_func_array([$this, $method], $args);
					$this->after();
				}
			} else {
				echo "Method $method not found in controller " . get_class($this);
			}


		}

		public function indexAction() {
			View::render("index.php");
		}


		public function testAction() {
			echo "This is test() in Home class";
		}

		protected function before() {
			return true;
		}

		protected function after() {
			
		}


	}

?>