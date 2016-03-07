<?php
/*
* Mysql database class - only one connection alowed
//https://gist.github.com/jonashansen229/4534794
//$db = Database::getInstance();
//$mysqli = $db->getConnection(); 
//$sql_query = "SELECT foo FROM .....";
//$result = $mysqli->query($sql_query);  
*/
class Database {
	private $_connection;
	private static $_instance; //The single instance
	private $_host     = dbhost;
	private $_database = dbname;
	private $_username = dbuser;
	private $_password = dbpass;
	
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	// Constructor
	private function __construct() {
		$this->_connection = new mysqli($this->_host, $this->_username, 
			$this->_password, $this->_database);
	
		// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),
				 E_USER_ERROR);
		}
	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}