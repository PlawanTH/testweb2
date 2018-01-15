<?php 

	namespace App\Controllers;

	use \Core\View;
	use \Core\Controller;
	use \App\Helpers\Validation;
	use \App\Models\User;

	class Register extends Controller {

		public function __call($name, $args) {

			$method = $name . 'Action';

			if (method_exists($this, $method)) {
				call_user_func_array([$this, $method], $args);
			}

		}

		public function indexAction() {
			View::render("register.php");
		}

		public function submitAction() {

			$data = [];

			if ($_SERVER['REQUEST_METHOD'] === "POST") {

				$name = $_POST['name'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$email = $_POST['email'];

				$errMsg = "";

				if ( !Validation::validateName($name) ) {
					$errMsg .= " name";
				}

				if ( !Validation::validateUsername($username) ) {
					if ( !empty($errMsg) ) {
						$errMsg .= ",";
					}
					$errMsg .= " username";
				}

				if ( !Validation::validatePassword($password) ) {
					if ( !empty($errMsg) ) {
						$errMsg .= ",";
					}
					$errMsg .= " password";
				}

				if ( !Validation::validateEmail($email) ) {
					if ( !empty($errMsg) ) {
						$errMsg .= ",";
					}
					$errMsg .= " email";
				}

				if ( !empty($errMsg) ) {
					$data['errMsg'] = "Wrong input: " . $errMsg;
					View::render("register.php", $data);
					return;
				}
				
				$password = password_hash($password, PASSWORD_DEFAULT);

				$user = new User($name, $username, $password, $email);
				$status = $user->addUser();

				if ( $status['success'] ) {
					$data['resultText'] = "User created successfully.";
				} else {
					$data['errMsg'] = $status['errMsg'];
				}

			}

			View::render("register.php", $data);

		}

	}

?>