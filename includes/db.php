<?php
// Connecting to and selecting a MySQL database named sakila
// Hostname: 127.0.0.1, username: your_user, password: your_pass, db: sakila
//
					//host	,   username , password , database name
$mysqli = new mysqli('localhost', 'root', 'rocchi28', 'undertalebattlesimulator');

function dbConnect(){
	global $mysqli;
	
if ($mysqli->connect_errno) {
    // The connection failed. What do you want to do? 
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit; //end all processing and code
	}
else // we 
	{
	// Perform an SQL query
	//echo "connected to db";
	}
}


dbConnect();


?>