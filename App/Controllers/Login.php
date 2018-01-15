<?php 

	namespace App\Controllers;

	use \Core\View;
	use \Core\Controller;
	use \App\Helpers\Validation;
	use \App\Models\User;

	class Login extends Controller {

		public function __call($name, $args) {

			$method = $name . 'Action';
			if (method_exists($this, $method)) {
				call_user_func_array([$this, $method], $args);
			} else {
				echo "Method $method not found in controller " . get_class($this);
			}

		}

		public function indexAction() {
			View::render("login.php");
		}

		public function submitAction() {

			$data = [];

			if ($_SERVER['REQUEST_METHOD'] === "POST") {

				if ( !isset($_POST['userInput']) || !isset($_POST['password']) ) {
					$data['errMsg'] = "Username/Email or Password does not set.";
					View::render("index.php", $data);
					return;
				}

				$userInput = $_POST['userInput'];
				$password = $_POST['password'];

				$user = $this->loginWithPassword($userInput, $password);

				if ($user != null) {
					$data['user'] = $user;
				} else {
					$data['errMsg'] = "Wrong username or password.";
				}

			}

			View::render("login.php", $data);

		}

		private function loginWithPassword($userInput, $password) {
			$inputType = Validation::getUserInputType($userInput);

			$user = User::getUser($userInput, $inputType);

			if (is_null($user)) {
				return null;
			}

			if ( password_verify($password, $user->getPassword()) ) {
				return $user;
			}

			return null;
		}

	}

?>
