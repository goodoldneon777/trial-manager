<?php
	require_once(SERVER_ROOT . '/php/dist/prepForSQL.php');


	$pageType = $_POST["pageType"];
	$seq = $_POST["seq"];
	$seq = prepForSQL($seq);
	$comment = json_decode($_POST["comment"]);
	$comment = prepForSQL($comment);

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
		$sql = "
			insert into trial_comment (trial_seq, comment_seq, comment_dt, comment_text)
			values (
	    	". $seq . ",
				(
					select ifnull(max_comment_seq, 0) + 1 as new_comment_seq
					from (
						select max(comment_seq) as max_comment_seq 
			    		from trial_comment
			    		where trial_seq = ". $seq . "
					) sub
				),
	    	now(),
			  ". $comment . "
			);
			";

		if (!$conn->query($sql)) {
		  $errors[] = $conn->error;
		}

		$debugSQL .= $sql;

	} else if ($pageType === 'group') {
		$sql = "
			insert into trial_group_comment (group_seq, comment_seq, comment_dt, comment_text)
			values (
	    	". $seq . ",
				(
					select ifnull(max_comment_seq, 0) + 1 as new_comment_seq
					from (
						select max(comment_seq) as max_comment_seq 
			    		from trial_group_comment
			    		where group_seq = ". $seq . "
					) sub
				),
	    	now(),
			  ". $comment. "
			)
			";

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