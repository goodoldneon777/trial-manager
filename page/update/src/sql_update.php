<?php
	require_once(SERVER_ROOT . '/php/dist/prepForSQL.php');

	
	$pageType = $_POST["pageType"];
	$seq = json_decode($_POST["seq"]);
	$seq = prepForSQL($seq);
	$info = json_decode($_POST["info"]);
	$info = prepForSQL($info);
	$oldCommentList = json_decode($_POST["oldCommentList"], true);
	$oldCommentList = prepForSQL($oldCommentList);
	$newCommentList = json_decode($_POST["newCommentList"], true);
	$newCommentList = prepForSQL($newCommentList);


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
		$heatData = prepForSQL($heatData);


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
			"  comment_conclusion = " . $info->conclusionText . ", \n" .
			"  update_dt = now() \n" .
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
		  	$commentSeq = $oldCommentList[$i][0];
				$commentDate = $oldCommentList[$i][1];
				$commentText = $oldCommentList[$i][2];

		  	if ($i > 0) {
		  		$sql .= "union \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . ", " .
					$commentSeq . ", " .
					$commentDate . ", " .
					$commentText . " \n";			
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
		  	$commentSeq = intval( removeStringWrap($newCommentList[$i][0]) );	//Remove single-quote wrap and convert string to integer.
		  	$commentSeq += $maxCommentSeq;	//Add the max comment seq on the table to ensure the new comments go after the old ones.
		  	$commentDate = $newCommentList[$i][1];
		  	$commentText = $newCommentList[$i][2];

		  	if ($i > 0) {
		  		$sql .= "union \n";
		  	}

		  	$sql .= 
		  		"select " .
					$seq . ", " .
					$commentSeq . ", " .
					$commentDate . ", " .
					$commentText . " \n";			
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
			"  trial_unit = " . $info->unit . ", \n" .
			"  trial_start_dt = " . $info->startDate . ", \n" .
			"  trial_end_dt = " . $info->endDate . " \n" .
			"where trial_seq = " . $seq . " \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}
		
		$debugSQL .= $sql;

	} else if ($pageType === 'group') {
		$childTrialList = json_decode($_POST["childTrialList"], true);
		$childTrialList = prepForSQL($childTrialList);


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
			"  comment_conclusion = " . $info->conclusionText . ", \n" .
			"  update_dt = now() \n" .
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



		$trialSeqStr = "";
		if (count($childTrialList) > 0) {
			$trialSeqStr = "(";
			for ($i = 0; $i <= count($childTrialList) - 1; $i++) {
				if ($i > 0) {
					$trialSeqStr .= ", ";
				}
				$trialSeqStr .= $childTrialList[$i];
			}
			$trialSeqStr .= ")";
		}

		$sql =
			"delete from trial_group_child \n" .
			"where group_seq = " . $seq;
		if ($trialSeqStr !== "") {
			$sql .= "\n  and trial_seq not in " . $trialSeqStr;
		}
		$sql .= "; \n\n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		if (count($childTrialList) > 0) {
			$sql = 
		  	"insert into trial_group_child ( \n" .
				"  group_seq, group_name, group_start_dt, group_end_dt, trial_seq, trial_name, trial_unit, trial_start_dt, trial_end_dt \n" .
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
					"trial.trial_seq, " .
					"trial.name as trial_name, " .
					"trial.unit as trial_unit, " .
					"trial.start_dt as trial_start_dt, " .
					"trial.end_dt as trial_end_dt \n" .
					"from trial \n" .
					"left outer join trial_group_child \n" .
					"  on trial.trial_seq = trial_group_child.trial_seq \n" .
					"where trial.trial_seq = " . $childTrialList[$i];
					if ($trialSeqStr !== "") {
						$sql .= 
							" \n" .
							"  and ( \n" .
							"    trial.trial_seq not in " . $trialSeqStr . " \n" .
							"    or trial_group_child.trial_seq is null \n" .
							"  )";
					}
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
	$output->seq = removeStringWrap($seq);
	$output->debugSQL = $debugSQL;


	echo json_encode($output);


	$conn->close();
?>




