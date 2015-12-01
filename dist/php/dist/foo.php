<?php


	$servername = "localhost";
	$username = "trial_mgr_ro";
	$password = "manofsteel";
	$dbname = "trial_mgr";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$city = chr(92) . 'hi' . chr(92);
	$city = $conn->real_escape_string($city);

	var_dump($city);


	$conn->close();
?>