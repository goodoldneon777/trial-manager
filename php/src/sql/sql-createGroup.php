<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");
	
	
	$info = json_decode($_POST["info"]);

	$debugSQL = '';


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	   die("Connection failed: " . $conn->connect_error);
	}


	mysqli_autocommit($conn, FALSE);

	$errors = array();


	$sql = 
		"insert into trial_group ( \n" .
		"  name, owner, start_dt, end_dt, unit, goal_type, change_type, bop_vsl, degas_vsl, argon_station, caster_num, strand_num, comment_goal, comment_monitor, comment_general, comment_conclusion \n" .
		") \n" .
		"value (" .
		$info->name . ", " .
		$info->owner . ", " .
		$info->startDate . ", " .
		$info->endDate . ", " .
		$info->unit . ", " .
		$info->goalType . ", " .
		$info->changeType . ", " .
		$info->bopVsl . ", " .
		$info->degasVsl . ", " .
		$info->argonNum . ", " .
		$info->casterNum . ", " .
		$info->strandNum . ", " .
		$info->goalText . ", " .
		$info->monitorText . ", " .
		$info->otherInfoText . ", " .
		$info->conclusionText .
		" ) \n";

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}

	$debugSQL .= $sql;



	$sql = "select max(group_seq) from trial_group";
	$result = $conn->query($sql);
  $arr = $result->fetch_array();
  $seq = $arr[0];

	$debugSQL .= $sql;




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