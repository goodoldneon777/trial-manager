<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");


	$trialSeq = json_decode($_POST["trialSeq"]);
	$trialComment_add = json_decode($_POST["trialComment_add"]);
	$commentText = $trialComment_add->commentText;


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 



	mysqli_autocommit($conn, FALSE);

	$errors = array();


	$sql = "
		insert into trial_comment (trial_seq, comment_seq, comment_dt, comment_text)
		values (
    	". $trialSeq . ",
			(
				select ifnull(max_comment_seq, 0) + 1 as new_comment_seq
				from (
					select max(comment_seq) as max_comment_seq 
		    		from trial_comment
		    		where trial_seq = ". $trialSeq . "
				) sub
			),
    	now(),
		  ". $commentText . "
		)
		";

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
	$output->errors = $commentText;
	$output->trialSeq = $trialSeq;


	echo json_encode($output);


	$conn->close();
?>