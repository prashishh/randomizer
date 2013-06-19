wampwa<?php

class Randomizer
{
	// database config
	protected $hostname;
	protected $username;
	protected $password;
	protected $portnumber;
	protected $database;
	protected $error; 
	protected $connection;
	protected $PrimaryField =  "ID";
	protected $data;
	protected $op = array(0=>"insert", 1=>"update", 2=>"delete"); //mimimizes the use of function
	
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
		
		return true;
	}

	// close database connection
	private function closeDatabase() {
		if($this->connection){mysql_close($this->connection);}
	}

	// randomize main function
	public function randomize($table, $values, $primay_field = "ID") {
	$this->PrimaryField = $primary_field;		
        $operation = $this->op[$this->getRandom(2)];

        if($operation == 'insert')
			return $this->insertOperation($table, $values);
		else if($operation == 'update')
			return $this->updateOperation($table, $values);
		else
			return $this->deleteOperation($table);

	}

	
	
	// gets random number, input string
	private function getRandom($length) {
		return mt_rand(0, $length); 
	}
	
	
	public function randomizer_error(){
		return $this->error;
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
		if(!mysql_query('INSERT INTO ' . $table . ' VALUES ( "", ' . $new_values . ');', $this->connection)){
			$this->error = "Could not Insert to Database. MySQL Error: ". mysql_error();
			return false;	
		} 
		return true;
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
		if(!mysql_query('UPDATE ' . $table . ' SET ' . $temp_keys[$random_column] . '="' . $temp_array[$temp_keys[$random_column]][$random_row] . '" WHERE ID = "' . $random_id[0] . '";', $this->connection)){
			$this->error = "Could not Update in Databse. MySQL Error: ". mysql_error();
			return false;
		}
		return true;
	}	


	// delete random record of a table
	private function deleteOperation($table) {
	
		// get random array from sql table
		$result = mysql_query('SELECT ID FROM ' . $table . ' LIMIT 1;', $this->connection) or die(mysql_error());
		$random_id = mysql_fetch_row($result);
		
		// update query
		if(!mysql_query('DELETE FROM ' . $table . ' WHERE '.$this->PrimaryField.'= "' . $random_id[0] . '";', $this->connection)){
			$this->error = "Could not Delete from Database. MySQL Error: ". mysql_error(); 
			return false;
		}

		return true;
	}	  
	
	// increment records by a random value of a table
	public function incrementOperation($table, $column, $values = array("1")) {
		$random_value = $this->getRandom(sizeof($values)-1);

		// increment
		if(!mysql_query('UPDATE ' . $table . ' SET ' . $column . '=' . $column . '+' . $values[$random_value] . ';', $this->connection)){
		$this->error = "Could not Increment in Databse. MySQL Error: ". mysql_error();
		return false;
		}
		return true;
	}

	// decrement records by a random value of a table
	public function decrementOperation($table, $column, $values = array("1")) {
		$random_value = $this->getRandom(sizeof($values)-1);

		// decrement
		if(!mysql_query('UPDATE ' . $table . ' SET ' . $column . '=' . $column . '-' . $values[$random_value] . ';', $this->connection)){
			$this->error = "Could not Increment in Databse. MySQL Error: ". mysql_error();
			return false;
		}
		return true;
	}

	//Sets/Gets Primary Field 
	public function setPrimaryField($value){
		$this->PrimaryField = $value;
	}
	
	public function getPrimaryField(){
		return $this->PrimaryField;
	}
	
	public function __destruct(){
		$this->closeDatabase();
	}

} 

?>
