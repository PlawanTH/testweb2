<?php
	
	namespace Core;

	use \mysqli;

	abstract class Model {

		protected static function getDB() {

		static $db = null;

			if ($db === null) {
				$host = 'localhost';
				$dbname = 'qqkung';
				$username = 'root';
				$password = '1234';

				$db = new mysqli($host, $username, $password, $dbname);

				if ($db->connect_error) {
					die("Connection failed: ". $db->connect_error);
				}
			}

			return $db;
		}

	}

?>