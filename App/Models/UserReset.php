<?php

	namespace App\Models;

	use \Core\Model;

	class UserReset extends Model {

		private $email;
		private $token;

		public function __construct($email) {
			$this->email = $email;
		}

		public function createResetLink() {

			$success = false;
			
			$this->generateToken();
			if ( $this->isEverReset() ) {
				$success = $this->updateToDatabase();
			} else {
				$success = $this->addToDatabase();
			}

			return $success;
		}

		public function getResetLink() {
			$link = "reset?token=$this->token&email=$this->email";
			return $link;
		}

		private function generateToken() {
			$this->token = openssl_random_pseudo_bytes(16);
			$this->token = bin2hex($this->token);
		}

		private function isEverReset() {
			$result = false;

			$email = $this->email;

			$db = parent::getDB();

			$sql = "SELECT email FROM PasswordReset WHERE email = ?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows > 0) {
				$result = true;
			}

			$stmt->free_result();
			$stmt->close();

			return $result;

		}

		private function addToDatabase() {
			$result = false;

			$time = time()+30;

			$db = parent::getDB();
			$sql = "INSERT INTO PasswordReset (email, token, expire) VALUES (?, ?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("ssi", $this->email, $this->token, $time);
			
			if ( $stmt->execute() ) {
				$result = true;
			} else {
				$errMsg = "Error: " . $sql . "<br>" . $stmt->error;
			}
			$stmt->close();

			return $result;

		}

		private function updateToDatabase() {
			$result = false;

			$time = time()+30;

			$db = parent::getDB();
			$sql = "UPDATE PasswordReset SET expire = $time, token = '$this->token' WHERE email = ?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("s", $this->email);

			if ( $stmt->execute() ) {
				$result = true;
			} else {
				$errMsg = "Error updating record: " . $sql . "<br>" . $stmt->error;
			}

			$stmt->close();

			return $result;
		}

		public static function checkResetLink($email, $token) {
			$result = false;
			$db = parent::getDB();

			$sql = "SELECT email, token, expire FROM PasswordReset WHERE email = ?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($realEmail, $realToken, $realExpire);


			if ( $stmt->num_rows > 0 ) {
				$stmt->fetch();
				if ($token == $realToken && $realExpire > time()) {
					$result = true;
				}
			}
			
			$stmt->free_result();
			$stmt->close();

			return $result;
		}

	}

?>