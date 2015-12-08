<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");


	$trialSeq = $_POST['trialSeq'];
	

	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	$sql = 
		"select \n" .
		"  ht_num, tap_yr, bop_vsl, degas_vsl, argon_num, caster_num, strand_num, comment \n" .
		"from trial_ht \n" .
		"where trial_seq = " . $trialSeq . " \n" .
		"order by ht_seq asc;";


	$result = $conn->query($sql);

	$rows = array();
	while ($row = $result->fetch_array(MYSQLI_NUM)) {
	  $rows[] = $row;
	}


	echo json_encode($rows);


	$conn->close();

?>