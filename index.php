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
	protected $data;

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
	public function randomize($table, $values) {
		
        $operation = $this->getOperation();

        if($operation == 'insert')
			$this->insertOperation($table, $values);
		else if($operation == 'update')
			$this->updateOperation($table, $values);
		else
			$this->deleteOperation($table);

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

	// insert random values to a table
	private function insertOperation($table, $temp_array) {

		// new values' array
		$new_array = array();
		
		// for fetching via index
		$temp_values = array_values($temp_array);
		$temp_keys = array_keys($temp_array);
		
		// get random row for each column
		for ( $i = 0; $i < sizeof($temp_array); $i++ ) {
			$random_row = $this->getRandom(sizeof($temp_values[$i])-1);
			echo $temp_keys[$i] . ' -> ' . $temp_array[$temp_keys[$i]][$random_row] . '<br>';
			array_push($new_array, "'" . $temp_array[$temp_keys[$i]][$random_row] . "'");
		} 

		// implode with comma for insert operation
		$new_values = implode(",", $new_array);

		// insertion
		mysql_query('INSERT INTO ' . $table . ' VALUES ( "", ' . $new_values . ');', $this->connection) or die(mysql_error());

		echo "Successfully Inserted!";
	}

	// update random value of a table
	private function updateOperation($table, $temp_array) {
		
		// for fetching via index
		$temp_values = array_values($temp_array);
		$temp_keys = array_keys($temp_array);
		
		// random key and value selected 
		$random_column = $this->getRandom(sizeof($temp_keys)-1);
		$random_row = $this->getRandom(sizeof($temp_values[$random_column])-1);
		
		echo $temp_keys[$random_column] . ' -> ' . $temp_array[$temp_keys[$random_column]][$random_row] . '<br>';

		// get random array from sql table
		$result = mysql_query('SELECT ID FROM ' . $table . ' LIMIT 1;', $this->connection) or die(mysql_error());
		$random_id = mysql_fetch_row($result);
		
		// update query
		mysql_query('UPDATE ' . $table . ' SET ' . $temp_keys[$random_column] . '="' . $temp_array[$temp_keys[$random_column]][$random_row] . '" WHERE ID = "' . $random_id[0] . '";', $this->connection) or die(mysql_error());

		echo "Successfully Updated!";
	}	


	// update random value of a table
	private function deleteOperation($table) {
	
		// get random array from sql table
		$result = mysql_query('SELECT ID FROM ' . $table . ' LIMIT 1;', $this->connection) or die(mysql_error());
		$random_id = mysql_fetch_row($result);
		
		// update query
		mysql_query('DELETE FROM ' . $table . ' WHERE ID = "' . $random_id[0] . '";', $this->connection) or die(mysql_error());

		echo "Successfully Deleted!";
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

// call this function to start operation
$obj->randomize("table1", $values);

// 

?>
