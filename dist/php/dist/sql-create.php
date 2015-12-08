<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");
	
	
	$trialInfo = json_decode($_POST["trialInfo"]);
	$trialHeatData = json_decode($_POST["trialHeatData"]);

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
		"insert into trial ( \n" .
		"  trial_name, user, start_dt, end_dt, proc_chg_num, twi_num, unit, trial_type, change_type, bop_vsl, degas_vsl, argon_station, caster_num, strand_num, comment_goal, comment_monitor, comment_general, comment_conclusion \n" .
		") \n" .
		"value (" .
		$trialInfo->trialName . ", " .
		$trialInfo->owner . ", " .
		$trialInfo->startDate . ", " .
		$trialInfo->endDate . ", " .
		$trialInfo->processChange . ", " .
		$trialInfo->twi . ", " .
		$trialInfo->unit . ", " .
		$trialInfo->trialType . ", " .
		$trialInfo->changeType . ", " .
		$trialInfo->bopVsl . ", " .
		$trialInfo->degasVsl . ", " .
		$trialInfo->argonNum . ", " .
		$trialInfo->casterNum . ", " .
		$trialInfo->strandNum . ", " .
		$trialInfo->goalText . ", " .
		$trialInfo->monitorText . ", " .
		$trialInfo->otherInfoText . ", " .
		$trialInfo->conclusionText .
		" ) \n";

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}

	$debugSQL .= $sql;



	$sql = "select max(trial_seq) from trial";
	$result = $conn->query($sql);
  $trialSeq = $result->fetch_array();
  $trialSeq = $trialSeq[0];

	$debugSQL .= $sql;



	if (count($trialHeatData) > 0) {
		$sql = 
	  	"insert into trial_ht ( \n" .
			"  trial_seq, trial_name, trial_start_dt, trial_end_dt, ht_seq, ht_num, tap_yr, bop_vsl, degas_vsl, argon_num, caster_num, strand_num, comment \n" .
			") \n";

	  for ($i = 0; $i <= count($trialHeatData) - 1; $i++) {
	  	if ($i > 0) {
	  		$sql .= "union \n";
	  	}

	  	$sql .= 
	  		"select " .
				"trial_seq, trial_name, start_dt, end_dt, " .
				$trialHeatData[$i][0] . ", " .
				$trialHeatData[$i][1] . ", " .
				$trialHeatData[$i][2] . ", " .
				$trialHeatData[$i][3] . ", " .
				$trialHeatData[$i][4] . ", " .
				$trialHeatData[$i][5] . ", " .
				$trialHeatData[$i][6] . ", " .
				$trialHeatData[$i][7] . ", " .
				$trialHeatData[$i][8] . " \n" .
				"from trial \n" .
				"where trial_seq = " . $trialSeq . " ";		
	  }

	  if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;
	}



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
	$output->trialSeq = $trialSeq;
	$output->debugSQL = $debugSQL;


	echo json_encode($output);


	$conn->close();
?>