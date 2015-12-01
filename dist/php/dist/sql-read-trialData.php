<?php
	$trialSeq = $_POST['trialSeq'];


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


	$sql = 
		"select \n" .
		"  ht_num, tap_yr, bop_vsl, degas_vsl, argon_num, caster_num, strand_num, comment \n" .
		"from trial_ht \n" .
		"where trial_seq = " . $trialSeq;


	$result = $conn->query($sql);

	$rows = array();
	while ($row = $result->fetch_array(MYSQLI_NUM)) {
	  $rows[] = $row;
	}

	// $foo = mysql_fetch_array($result, MYSQL_NUM);

	echo json_encode($rows);

	$conn->close();

?>