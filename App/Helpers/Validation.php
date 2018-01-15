<?php

	namespace App\Helpers;

	class Validation {

		public static function validateName($name) {
			$name = trim($name);
			if (strlen($name) > 30 || strlen($name) < 2 || empty($name)) {
				return false;
			}
			return true;
		}

		public static function validateUsername($username) {
			$username = trim($username);
			if (strlen($username) > 16 || empty($username) || preg_match('/[^a-zA-Z0-9]+/', $username)) {
				return false;
			}
			return true;
		}

		public static function validatePassword($password) {
			if (empty($password)) {
				return false;
			}
			return true;
		}

		public static function validateEmail($email) {
			$email = trim($email);
			if ( preg_match('/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,})$/', $email) ) {
				return true;
			}
			return false;
		}

		public static function getUserInputType($input) {
			$type = null;
			if ( self::validateEmail($input) ) {
				$type = 'email';
			} else {
				$type = 'username';
			}

			return $type;
		}
	}

?>