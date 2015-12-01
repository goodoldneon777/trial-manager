<?php
	$trialSeq = json_decode($_POST["trialSeq"]);
	$o_trialComment_add = json_decode($_POST["o_trialComment_add"]);


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

	$sql = "
		insert into trial_comment (trial_seq, comment_seq, insert_dt, comment_text)
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
		  ". $o_trialComment_add->commentText . "
		)
		";



	// $conn->query($sql);

	// if ($conn->query($sql))

	if ($conn->query($sql) === TRUE) {
	    $status = "success";
	} else {
	    $status = "failure";
	}


	$output = new stdClass();
	$output->status = $status;
	$output->trialSeq = $trialSeq;


	echo json_encode($output);

	$conn->close();
?>