<?php
	// Database credentials
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'game');

	// Connect MySQL database
	$mysql_database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if (!$mysql_database) 
	{
		die("Error: Unable to connect " . $mysql_database->connect_error);
	}