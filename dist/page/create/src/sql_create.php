<?php
	$pageType = $_POST["pageType"];
	$info = json_decode($_POST["info"]);

	$debugSQL = '';	// Will contain all the queries. For debugging purposes.
	$errors = array();

	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	   // die("Connection failed: " . $conn->connect_error);
		$errors[] = $conn->error;
	}

	mysqli_autocommit($conn, FALSE);


	if ($pageType === 'trial') {
		$heatData = json_decode($_POST["heatData"]);


		$sql = 
			"insert into trial ( \n" .
			"  name, owner, start_dt, end_dt, proc_chg_num, twi_num, unit, goal_type, change_type, bop_vsl, degas_vsl, argon_station, caster_num, strand_num, comment_goal, comment_monitor, comment_general, comment_conclusion, insert_dt \n" .
			") \n" .
			"value (" .
			$info->name . ", " .
			$info->owner . ", " .
			$info->startDate . ", " .
			$info->endDate . ", " .
			$info->processChange . ", " .
			$info->twi . ", " .
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
			$info->conclusionText . ", " .
			"now() " .
			" ); \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		$sql = "select max(trial_seq) from trial; \n";
		$result = $conn->query($sql);
	  $arr = $result->fetch_array();
	  $seq = $arr[0];

		$debugSQL .= $sql;	



		if (count($heatData) > 0) {
			$sql = 
		  	"insert into trial_ht ( \n" .
				"  trial_seq, trial_name, trial_start_dt, trial_end_dt, ht_seq, ht_num, tap_yr, bop_vsl, degas_vsl, argon_num, caster_num, strand_num, comment \n" .
				") \n";

		  for ($i = 0; $i <= count($heatData) - 1; $i++) {
		  	if ($i > 0) {
		  		$sql .= "union \n";
		  	}

		  	$sql .= 
		  		"select " .
					"trial_seq, name, start_dt, end_dt, " .
					$heatData[$i][0] . ", " .
					$heatData[$i][1] . ", " .
					$heatData[$i][2] . ", " .
					$heatData[$i][3] . ", " .
					$heatData[$i][4] . ", " .
					$heatData[$i][5] . ", " .
					$heatData[$i][6] . ", " .
					$heatData[$i][7] . ", " .
					$heatData[$i][8] . " \n" .
					"from trial \n" .
					"where trial_seq = " . $seq . " \n";		
		  }

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}

			$debugSQL .= $sql;
		}

	} else if ($pageType === 'group') {
		$childTrialList = json_decode($_POST["childTrialList"], true);


		$sql = 
			"insert into trial_group ( \n" .
			"  name, owner, start_dt, end_dt, unit, goal_type, change_type, bop_vsl, degas_vsl, argon_station, caster_num, strand_num, comment_goal, comment_monitor, comment_general, comment_conclusion, insert_dt \n" .
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
			$info->conclusionText . ", " .
			"now() " .
			" ) \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		$sql = "select max(group_seq) from trial_group; \n";
		$result = $conn->query($sql);
	  $arr = $result->fetch_array();
	  $seq = $arr[0];

		$debugSQL .= $sql;	



		if (count($childTrialList) > 0) {
			$sql = 
		  	"insert into trial_group_child ( \n" .
				"  group_seq, group_name, group_start_dt, group_end_dt, trial_seq, trial_name, trial_unit, trial_start_dt, trial_end_dt \n" .
				") \n";

		  for ($i = 0; $i <= count($childTrialList) - 1; $i++) {
		  	if ($i > 0) {
		  		$sql .= "union \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . " as group_seq, " .
					$info->name . " as group_name, " .
					$info->startDate . " as group_start_dt, " .
					$info->endDate . " as group_end_dt, " .
					"trial_seq, " .
					"name as trial_name, " .
					"unit as trial_unit, " .
					"start_dt as trial_start_dt, " .
					"end_dt as trial_end_dt \n" .
					"from trial \n" .
					"where trial_seq = " . $childTrialList[$i] . " \n";

		  }

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}
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
	$output->seq = $seq;
	$output->debugSQL = $debugSQL;


	echo json_encode($output);


	$conn->close();
?>