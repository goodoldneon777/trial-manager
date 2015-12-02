<?php
	$trialInfo = json_decode($_POST["trialInfo"]);
	$trialHeatData = json_decode($_POST["trialHeatData"]);

	$foo = $trialInfo->trialName;
	// $foo = "Trial Name";


	$servername = "localhost";
	$username = "trial_mgr_wr";
	$password = "womanofsteel";
	$dbname = "trial_mgr";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
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


	$sql = "select max(trial_seq) from trial";
	$result = $conn->query($sql);
  $trialSeq = $result->fetch_array();
  $trialSeq = $trialSeq[0];


	if (count($trialHeatData) > 0) {
		$sql = 
	  	"insert into trial_ht ( \n" .
			"  trial_seq, ht_seq, ht_num, tap_yr, bop_vsl, degas_vsl, argon_num, caster_num, strand_num, comment \n" .
			") \n";

	  for ($i = 0; $i <= count($trialHeatData) - 1; $i++) {
	  	if ($i > 0) {
	  		$sql .= "union \n";
	  	}

	  	$sql .= 
	  		"select " .
				"(select max(trial_seq) from trial), " .
				$trialHeatData[$i][0] . ", " .
				$trialHeatData[$i][1] . ", " .
				$trialHeatData[$i][2] . ", " .
				$trialHeatData[$i][3] . ", " .
				$trialHeatData[$i][4] . ", " .
				$trialHeatData[$i][5] . ", " .
				$trialHeatData[$i][6] . ", " .
				$trialHeatData[$i][7] . ", " .
				$trialHeatData[$i][8] . " \n";			
	  }

	  if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}
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


	echo json_encode($output);


	$conn->close();
?>