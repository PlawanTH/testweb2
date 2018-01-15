<?php 

	namespace App\Controllers;

	use \Core\Controller;
	use \Core\View;
	use \App\Helpers\Validation;
	use \App\Models\UserReset;
	use \App\Models\User;

	class Reset extends Controller {

		public function __call($name, $args) {

			$method = $name . 'Action';

			if (method_exists($this, $method)) {
				call_user_func_array([$this, $method], $args);
			}

		}

		public function indexAction() {

			$errMsg = "Reset link not available.";

			if ( !isset($_GET["email"]) || !isset($_GET["token"]) ) {
				$data = ['errMsg' => $errMsg];
				View::render("reset.php", $data);
				return;
			}

			$email = $_GET["email"];
			$token = $_GET["token"];

			if ( !Validation::validateEmail($email) || !UserReset::checkResetLink($email, $token)) {
				$data = ['errMsg' => $errMsg];
				View::render("reset.php", $data);
				return;
			}

			$data = ['token' => $token, 'email' => $email];
			View::render("reset.php", $data);
		}

		public function submitAction() {
			$data = [];

			if ($_SERVER['REQUEST_METHOD'] === "POST") {

				$password = $_POST['password'];
				$rpassword = $_POST['rpassword'];

				// check empty
				if ( !Validation::validatePassword($password) ) {
					$data['errMsg'] = "Invalid password.";
					View::render("reset.php", $data);
					return;
				}

				$email = $_POST['email'];
				$token = $_POST['token'];

				if ($password != $rpassword) {
					$data['errMsg'] = "Repeated password does not match.";
				} else {
					$password = password_hash($password, PASSWORD_DEFAULT);
					if ( User::updatePassword($email, $password, $token) ) {
						$data['resultText'] = "Password updated successfully";
					} else {
						$data['errMsg'] = "Error occur.";
					}
				}

			}

			View::render("reset.php", $data);
		}

	}

?>