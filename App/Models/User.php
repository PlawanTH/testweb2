<?php

namespace App\Models;

use \Core\Model;


class User extends Model {
	
	private $name;
	private $username;
	private $password;
	private $email;

	public function __construct($name, $user, $password, $email) {
		$this->name = $name;
		$this->username = $user;
		$this->password = $password;
		$this->email = $email;
	}

	public function getName() {
		return $this->name;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	// User function

	public function addUser() {

		$success = false;

		$name = $this->getName();
		$username = $this->getUsername();
		$password = $this->getPassword();
		$email = $this->getEmail();

		$db = parent::getDB();

		// check user & email is exists.
		if ( self::checkUserDataIsExists('username', $username) ) {
			return ['success' => false, 'errMsg' => "Username is in used."];
		}
		if ( self::checkUserDataIsExists('email', $email) ) {
			return ['success' => false, 'errMsg' => "Email is in used."];
		}

		// if not exists, insert to DB.
		$stmt = $db->prepare("INSERT INTO user (name, username, password, email) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $name, $username, $password, $email);

		if ( $stmt->execute() ) {
			$success = true;
		} else {
			$errMsg = "Error: " . $sql . "<br>" . $stmt->error;
			return ['success' => false, 'errMsg' => "Insert data error."];
		}

		$stmt->close();
		
		return ['success' => $success];
	}

	public static function getUser($userInput, $type = 'username') {

		$user = null;
		
		$db = parent::getDB();
		$stmt = $db->prepare("SELECT name, username, password, email FROM user WHERE $type = ?");
		$stmt->bind_param("s", $userInput);

		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($name, $username, $password, $email);

		if ($stmt->num_rows > 0) {
			$stmt->fetch();
			$user = new User($name, $username, $password, $email);
		}

		$stmt->free_result();
		$stmt->close();
			
		return $user;
	}

	public static function getUserByEmail($email) {
		
		return self::getUser($email, 'email');

	}

	public static function updatePassword($email, $password, $token) {
		$db = parent::getDB();

		$success = false;

		$time = time();

		$sql = "UPDATE User INNER JOIN PasswordReset ON User.email = PasswordReset.email SET password = ?, expire = $time WHERE User.email = ? AND token = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("sss", $password, $email, $token);
		

		if ( $stmt->execute() ) {
			if ( $stmt->affected_rows > 0 ) {
				$success = true;
			} else {
				$errMsg = "No user founded";
			}
		} else {
			$errMsg = "Error updating record: " . $stmt->error;
		}
		$stmt->close();

		return $success; 
	}

	public static function checkUserDataIsExists($inputType, $userInput) {
		$found = false;

		$db = parent::getDB();

		$sql = "SELECT $inputType FROM user WHERE $inputType = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("s", $userInput);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows > 0) {
			$found = true;
		}

		$stmt->free_result();
		$stmt->close();

		return $found;
	}

}

?>