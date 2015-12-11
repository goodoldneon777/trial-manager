<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");
	
	
	$groupInfo = json_decode($_POST["groupInfo"]);

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
		$groupInfo->name . ", " .
		$groupInfo->owner . ", " .
		$groupInfo->startDate . ", " .
		$groupInfo->endDate . ", " .
		$groupInfo->unit . ", " .
		$groupInfo->goalType . ", " .
		$groupInfo->changeType . ", " .
		$groupInfo->bopVsl . ", " .
		$groupInfo->degasVsl . ", " .
		$groupInfo->argonNum . ", " .
		$groupInfo->casterNum . ", " .
		$groupInfo->strandNum . ", " .
		$groupInfo->goalText . ", " .
		$groupInfo->monitorText . ", " .
		$groupInfo->otherInfoText . ", " .
		$groupInfo->conclusionText .
		" ) \n";

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}

	$debugSQL .= $sql;



	$sql = "select max(group_seq) from trial_group";
	$result = $conn->query($sql);
  $groupSeq = $result->fetch_array();
  $groupSeq = $groupSeq[0];

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
	$output->groupSeq = $groupSeq;
	$output->debugSQL = $debugSQL;


	echo json_encode($output);


	$conn->close();
?>