<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$seq = json_decode($_POST["seq"]);
	$info = json_decode($_POST["info"]);
	$commentList = json_decode($_POST["commentList"], true);
	$heatData = json_decode($_POST["heatData"]);


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
		"update trial \n" .
		"set  \n" .
		"  trial_name = " . $info->name . ", \n" .
		"  owner = " . $info->owner . ", \n" .
		"  start_dt = " . $info->startDate . ", \n" .
		"  end_dt = " . $info->endDate . ", \n" .
		"  proc_chg_num = " . $info->processChange . ", \n" .
		"  twi_num = " . $info->twi . ", \n" .
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
		"where trial_seq = " . $seq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


	$debugSQL .= $sql;	// Will contain all the queries. For debugging purposes.


	$sql =
		"delete from trial_comment \n" .
		"where trial_seq = " . $seq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


	if (count($commentList) > 0) {
		$sql = 
	  	"insert into trial_comment ( \n" .
			"  trial_seq, comment_seq, comment_dt, comment_text \n" .
			") \n";

	  for ($i = 0; $i <= count($commentList) - 1; $i++) {
	  	if ($i > 0) {
	  		$sql .= "union \n";
	  	}

	  	$sql .= 
	  		"select " .
				$seq . ", " .
				$commentList[$i][0] . ", " .
				$commentList[$i][1] . ", " .
				$commentList[$i][2] . " \n";			
	  }

	  if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}
	}


	$debugSQL .= $sql;	// Will contain all the queries. For debugging purposes.


	$sql =
		"delete from trial_ht \n" .
		"where trial_seq = " . $seq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


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
				"trial_seq, trial_name, start_dt, end_dt, " .
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
				"where trial_seq = " . $seq . " ";		
	  }

	  if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}
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