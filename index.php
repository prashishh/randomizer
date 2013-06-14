<?php

class Randomizer
{
	// database config
	protected $hostname;
	protected $username;
	protected $password;
	protected $portnumber;
	protected $database;

	protected $connection;

	function __construct($host, $user, $pass, $db) {
		$this->hostname = $host;
		$this->username = $user;
		$this->password = $pass;
		$this->database = $db;

		$this->connectDatabase();
	}

	// create database connection 
	private function connectDatabase() {
		
		$this->connection = mysql_connect($this->hostname,$this->username,$this->password);
		mysql_select_db($this->database, $this->connection);
	}

	// close database connection
	private function closeDatabase() {
		mysql_close($this->connection);
	}

	// randomize main function
	public function randomize($table, $column, $values) {
		$result = mysql_query('SELECT ' . $column . ' FROM ' . $table . ';', $this->connection);

		while ($row = mysql_fetch_assoc($result)) {
			var_dump($row);
		}
	}

	// gets random operation - insert, update, delete
	private function getOperation() {
		$operation = $this->getRandom(2);

		if ( $operation == 0 )
			return "insert";
		else if ($operation == 1 )
			return "update";
		else
			return "delete";
	}
	
	// gets random number, input string
	private function getRandom($length) {
		return mt_rand(0, $length); 
	}

} 
	
// pass database config
$obj = new Randomizer("localhost", "root", "", "tabledata");

// assign random values to columns
$values = array(
	'username' => array('Ram Prasad', 'Hari Gopal', 'Shyam Kesari'), 
	'datereg' => array('2012/01/11', '2013/01/11', '2012/05/12'), 
	'role' => array('Staff', 'Teacher', 'Lecturer'), 
	'status' => array('Banned', 'Active')
	);

//$obj->randomize("table1", $values);
?>
