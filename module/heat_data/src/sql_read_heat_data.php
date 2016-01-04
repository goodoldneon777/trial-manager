<?php
	require_once(SERVER_ROOT . '/php/dist/prepForSQL.php');


	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");


	$seq = json_decode($_POST['seq']);
	$seq = prepForSQL($seq);
	

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
		"where trial_seq = " . $seq . " \n" .
		"order by ht_seq asc;";


	$result = $conn->query($sql);

	$rows = array();
	while ($row = $result->fetch_array(MYSQLI_NUM)) {
	  $rows[] = $row;
	}


	$output = new stdClass();
	$output->data = $rows;
	$output->sql = $sql;

	echo json_encode($output);


	$conn->close();

?>