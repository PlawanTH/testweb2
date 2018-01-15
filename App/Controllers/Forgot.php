<?php 

	namespace App\Controllers;

	use \Core\View;
	use \Core\Controller;
	use \App\Helpers\Validation;
	use \App\Models\User;
	use \App\Models\UserReset;

	class Forgot extends Controller {

		public function __call($name, $args) {

			$method = $name . 'Action';

			if (method_exists($this, $method)) {
				call_user_func_array([$this, $method], $args);
			}

		}

		public function indexAction() {
			View::render("forgot.php");
		}

		public function submitAction() {

			$data = [];

			if ($_SERVER['REQUEST_METHOD'] === "POST") {

				$email = $_POST["email"];

				if ( !Validation::validateEmail($email) ) {
					$data['errMsg'] = "Wrong email input";
					View::render("forgot.php", $data);
					return;
				}

				if ( !User::checkUserDataIsExists('email', $email) ) {
					$data['errMsg'] = "No user founded.";
					View::render("forgot.php", $data);
					return;
				}

				$userReset = new UserReset($email);

				if ( $userReset->createResetLink() ) {
					$data['resetLink'] = $userReset->getResetLink();
				} else {
					$data['errMsg'] = "Error occur.";
				}

			}

			View::render("forgot.php", $data);

		}

	}

?>