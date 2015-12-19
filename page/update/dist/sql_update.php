<?php
	$pageType = $_POST["pageType"];
	$seq = json_decode($_POST["seq"]);
	$info = json_decode($_POST["info"]);
	$oldCommentList = json_decode($_POST["oldCommentList"], true);
	$newCommentList = json_decode($_POST["newCommentList"], true);

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
			"update trial \n" .
			"set  \n" .
			"  name = " . $info->name . ", \n" .
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
			"where trial_seq = " . $seq . "; \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		$sql =
			"delete from trial_comment \n" .
			"where trial_seq = " . $seq . "; \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;	



		if (count($oldCommentList) > 0) {
			$sql = 
		  	"insert into trial_comment ( \n" .
				"  trial_seq, comment_seq, comment_dt, comment_text \n" .
				") \n";

		  for ($i = 0; $i <= count($oldCommentList) - 1; $i++) {
		  	if ($i > 0) {
		  		$sql .= "union \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . ", " .
					$oldCommentList[$i][0] . ", " .
					$oldCommentList[$i][1] . ", " .
					$oldCommentList[$i][2] . " \n";			
		  }

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}

			$debugSQL .= $sql;
		}



		$sql = 
			"select max(comment_seq) \n" .
			"from trial_comment \n" .
			"where trial_seq = " . $seq . "; \n\n";
		$result = $conn->query($sql);
	  $arr = $result->fetch_array();
	  $maxCommentSeq = $arr[0];

		$debugSQL .= $sql;



		if (count($newCommentList) > 0) {
			$sql = 
		  	"insert into trial_comment ( \n" .
				"  trial_seq, comment_seq, comment_dt, comment_text \n" .
				") \n";

		  for ($i = 0; $i <= count($newCommentList) - 1; $i++) {
		  	if ($i > 0) {
		  		$sql .= "union \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . ", " .
					($newCommentList[$i][0] + $maxCommentSeq) . ", " .
					$newCommentList[$i][1] . ", " .
					$newCommentList[$i][2] . " \n";			
		  }

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}

			$debugSQL .= $sql;
		}



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
					"where trial_seq = " . $seq . " ";		
		  }

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}
		
			$debugSQL .= $sql;
		}



		$sql =
			"update trial_group_child \n" .
			"set \n" .
			"  trial_name = " . $info->name . ", \n" .
			"  trial_start_dt = " . $info->startDate . ", \n" .
			"  trial_end_dt = " . $info->endDate . " \n" .
			"where trial_seq = " . $seq . " \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}
		
		$debugSQL .= $sql;

	} else if ($pageType === 'group') {
		$childTrialList = json_decode($_POST["childTrialList"], true);


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
		"where group_seq = " . $seq . "; \n\n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		$sql =
			"delete from trial_group_child \n" .
			"where group_seq = " . $seq . "; \n\n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		$sql =
			"delete from trial_group_comment \n" .
			"where group_seq = " . $seq . "; \n\n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		if (count($oldCommentList) > 0) {
			$sql = 
		  	"insert into trial_group_comment ( \n" .
				"  group_seq, comment_seq, comment_dt, comment_text \n" .
				") \n";

		  for ($i = 0; $i <= count($oldCommentList) - 1; $i++) {
		  	if ($i > 0) {
		  		$sql .= "\nunion \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . ", " .
					$oldCommentList[$i][0] . ", " .
					$oldCommentList[$i][1] . ", " .
					$oldCommentList[$i][2];			
		  }

		  $sql .= "; \n\n";

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}

			$debugSQL .= $sql;
		}



		$sql = 
			"select max(comment_seq) \n" .
			"from trial_group_comment \n" .
			"where group_seq = " . $seq . "; \n\n";
		$result = $conn->query($sql);
	  $arr = $result->fetch_array();
	  $maxCommentSeq = $arr[0];

		$debugSQL .= $sql;	

		

		if (count($newCommentList) > 0) {
			$sql = 
		  	"insert into trial_group_comment ( \n" .
				"  group_seq, comment_seq, comment_dt, comment_text \n" .
				") \n";

		  for ($i = 0; $i <= count($newCommentList) - 1; $i++) {
		  	if ($i > 0) {
		  		$sql .= "\nunion \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . ", " .
					($newCommentList[$i][0] + $maxCommentSeq) . ", " .
					$newCommentList[$i][1] . ", " .
					$newCommentList[$i][2];			
		  }

		  $sql .= "; \n\n";

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}

			$debugSQL .= $sql;
		}



		if (count($childTrialList) > 0) {
			$sql = 
		  	"insert into trial_group_child ( \n" .
				"  group_seq, group_name, group_start_dt, group_end_dt, trial_seq, trial_name, trial_start_dt, trial_end_dt \n" .
				") \n";

		  for ($i = 0; $i <= count($childTrialList) - 1; $i++) {
		  	if ($i > 0) {
		  		$sql .= "\nunion \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . " as group_seq, " .
					$info->name . " as group_name, " .
					$info->startDate . " as group_start_dt, " .
					$info->endDate . " as group_end_dt, " .
					"trial_seq, " .
					"name as trial_name, " .
					"start_dt as trial_start_dt, " .
					"end_dt as trial_end_dt \n" .
					"from trial \n" .
					"where trial_seq = " . $childTrialList[$i];
		  }

		  $sql .= "; \n\n";

		  if (!$conn->query($sql)) {
			  $errors[] = $conn->error;
			}

			$debugSQL .= $sql;
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
	$output->seq = $seq;
	$output->debugSQL = $debugSQL;


	echo json_encode($output);


	$conn->close();
?>




