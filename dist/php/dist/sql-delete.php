<?php
	$trialSeq = $_POST["trialSeq"];


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
		"delete from trial \n" .
		"where trial_seq = " . $trialSeq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


	$sql = 
		"delete from trial_comment \n" .
		"where trial_seq = " . $trialSeq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


	$sql = 
		"delete from trial_ht \n" .
		"where trial_seq = " . $trialSeq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
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