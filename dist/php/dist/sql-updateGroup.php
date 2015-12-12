<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$seq = json_decode($_POST["seq"]);
	$info = json_decode($_POST["info"]);


	$debugSQL = "";	// Will contain all the queries. For debugging purposes.


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	mysqli_autocommit($conn, FALSE);

	$errors = array();


	$sql = 
		"update trial_group \n" .
		"set  \n" .
		"  name = " . $info->name . ", \n" .
		"  owner = " . $info->owner . ", \n" .
		"  start_dt = " . $info->startDate . ", \n" .
		"  end_dt = " . $info->endDate . ", \n" .
		"  unit = " . $info->unit . ", \n" .
		"  goal_type = " . $info->goalType . ", \n" .
		"  change_type = " . $info->changeType . ", \n" .
		"  bop_vsl = " . $info->bopVsl . ", \n" .
		"  degas_vsl = " . $info->degasVsl . ", \n" .
		"  argon_station = " . $info->argonNum . ", \n" .
		"  caster_num = " . $info->casterNum . ", \n" .
		"  strand_num = " . $info->strandNum . ", \n" .
		"  comment_goal = " . $info->goalText . ", \n" .
		"  comment_monitor = " . $info->monitorText . ", \n" .
		"  comment_general = " . $info->otherInfoText . ", \n" .
		"  comment_conclusion = " . $info->conclusionText . " \n" .
		"where group_seq = " . $seq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


	$debugSQL .= $sql;	// Will contain all the queries. For debugging purposes.



	if(count($errors) === 0) {
    $conn->commit();
    $status = "success";
	} else {
	  $conn->rollback();
	  $status = "failure";
	}


	$output = new stdClass();
	$output->status = $status;
	$output->errors = $errors;
	$output->seq = $seq;
	$output->debugSQL = $debugSQL;


	echo json_encode($output);


	$conn->close();
?>