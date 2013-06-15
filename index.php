<?php
	include('randomizer.php');

	function setInterval($f, $milliseconds)
	{
	    $seconds=(int)$milliseconds/1000;
	    while(true)
	    {
	        $f();
	        sleep($seconds);
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

/*
	// calls function after every 2 second
	// rough but what the hell
	setInterval(function(){
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
	}, 2000);
*/
?>