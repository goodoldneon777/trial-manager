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


	try {
		$conn->autocommit(FALSE);

		$sql = "
			delete from trial
			where trial_seq = " . $trialSeq . "
			";

		$conn->query($sql);


		$sql = "
			delete from trial_comment
			where trial_seq = " . $trialSeq . "
			";

		$conn->query($sql);


		$sql = "
			delete from trial_ht
			where trial_seq = " . $trialSeq . "
			";

		$conn->query($sql);


		$conn->commit();
		$status = "success";
	} catch (Exception $e) {
		// An exception has been thrown
    // We must rollback the transaction
    $conn->rollback();
    $status = "failure";
  }


	echo json_encode($status);

	$conn->close();
?>