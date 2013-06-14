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

	private function connectDatabase() {
		
		// create connection
		$this->connection = mysql_connect($this->hostname,$this->username,$this->password);
		mysql_select_db($this->database, $this->connection);

		$result = mysql_query('SELECT * FROM table1;', $this->connection);
		$values = mysql_fetch_array($result);
		var_dump($values);
	}


	private function closeDatabase() {
		mysql_close($this->connection);
	}

	public randomize($table, $values) {
		
	}
}
	
// pass database config
$obj = new Randomizer("localhost", "root", "", "tabledata");


?>