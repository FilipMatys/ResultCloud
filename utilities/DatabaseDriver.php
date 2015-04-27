<?php

/**
* @author Bohdan Iakymets
**/

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_SERVICE_APPLICATION);

class DatabaseDriver {
	public static $db;
	public static $dbConfig;
	public static $connected;
	/**
	* Connect to Database if connection doesn't exist
	**/
	public function connect() {
		//Check connection
		if (empty(self::$connected) || self::$connected === false) {
			//If it is not exist connect
			self::$dbConfig = ConfigurationService::Database();
			self::$db = new mysqli(self::$dbConfig->Data["hostname"], self::$dbConfig->Data["username"], 
				self::$dbConfig->Data["password"], self::$dbConfig->Data["database"]);

			if ($this->db->connect_errno > 0)   {
	            die ('Unable to connect to database[' . $this->db->connect_error . ']');
	        }
		}
	}

	/**
	* Set connection
	**/
	public function ConnectExisting($db) {
		self::$db = $db;
		self::$connected = true;
	}
}
?>