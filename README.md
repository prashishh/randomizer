## randomizer

### Introduction
Randomly insert, update or delete data from SQL table(s). Used in demo for real time apps.

#### How to use
- call Randomizer() with required parameters
- assign an array of array with values that you want to insert or update (example below)
- throw the randomize method with table name and the values array

```php
// pass database config
$obj = new Randomizer("<hostname>", "<username>", "<password>", "<tablename>");
```
__parameters__ are self-explanatory

```php
// assign random values to columns
$values = array(
	'username' => array('Ram Prasad', 'Hari Gopal', 'Shyam Kesari'), 
	'datereg' => array('2012/01/11', '2013/01/11', '2012/05/12'), 
	'role' => array('Staff', 'Teacher', 'Lecturer'), 
	'status' => array('Banned', 'Active')
	);
```
The array keys (username, datereg, role and status) are column names as in the SQL table.
Their respective arrays are the values that you want to assign them.```

```php
// call this function to start operation
$obj->randomize(<tablename>, <values array>);
```

__Update:__
Added functions incrementOperation() and decrementOperation() to increase or decrease value of records of a table randomly.

```php
$obj = new Randomizer("<hostname>", "<username>", "<password>", "<tablename>");

$values = array("1", "2", "3");
$obj->decrementOperation("<table name>", "<column name>", <value array>);
echo ($obj->randomizer_error());

```

__Note:__ If you want to change values of your db repeatedly (for real-time apps demo) then call this page with setInterval() or similar function

### Full Code Example:

```php
	
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

```
#### Update: 
A quick search gave me this [result][so] from stackoverflow:

```php
function setInterval($f, $milliseconds)
{
    $seconds=(int)$milliseconds/1000;
    while(true)
    {
        $f();
        sleep($seconds);
    }
}

setInterval(function(){
    // call function here
}, 1000);

```

[so]: http://stackoverflow.com/questions/12783737/how-to-use-setinterval-in-php