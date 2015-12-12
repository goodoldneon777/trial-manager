<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$seq = json_decode($_POST["seq"]);
	$info = json_decode($_POST["info"]);
	$commentList = json_decode($_POST["commentList"], true);


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


	$sql =
		"delete from trial_group_comment \n" .
		"where group_seq = " . $seq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


	if (count($commentList) > 0) {
		$sql = 
	  	"insert into trial_group_comment ( \n" .
			"  group_seq, comment_seq, comment_dt, comment_text \n" .
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