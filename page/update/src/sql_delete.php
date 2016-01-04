<?php
	require_once(SERVER_ROOT . '/php/dist/prepForSQL.php');


	$pageType = $_POST["pageType"];
	$seq = json_decode($_POST["seq"]);
	$seq = prepForSQL($seq);

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
			"delete from trial \n" .
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



		$sql =
			"delete from trial_ht \n" .
			"where trial_seq = " . $seq . "; \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



		$sql =
			"update trial_group_child \n" .
			"set deleted_flag = 1 \n" .
			"where trial_seq = " . $seq . "; \n";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;



	} else if ($pageType === 'group') {
		$childTrialList = json_decode($_POST["childTrialList"], true);


		$sql = 
		"delete from trial_group \n" .
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




