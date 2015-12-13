<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$seq = json_decode($_POST["trialSeq"]);


	$debugSQL = "";	// Will contain all the queries. For debugging purposes.


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	mysqli_autocommit($conn, FALSE);

	$errors = array();


	$sql = "
			select trial_seq, trial_name, unit, start_dt, end_dt
			from join trial
			where trial_seq = " . $seq;

	if (!$conn->query($sql)) {
	  $errors[] = $conn->error;
	}


	$debugSQL .= $sql;	// Will contain all the queries. For debugging purposes.


	$html = 
  	"<tr> \n" .
  	"  <td><a href=\"view.php?trialseq=" . $row["trial_seq"] . "\">" . $row["trial_name"] . "</a></td> \n" .
  	"  <td>" . $row["unit"] . "</td> \n" .
  	"  <td>" . date_format(date_create($row["start_dt"]), "n/j/Y") . "</td> \n" .
  	"  <td>" . date_format(date_create($row["end_dt"]), "n/j/Y") . "</td> \n" .
  	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
  	"    <a href=\"view.php?trialseq=" . $row["trial_seq"] . "\">View</a> \n" .
  	"    | \n" .
  	"    <a href=\"comment.php?trialseq=" . $row["trial_seq"] . "\">Comment</a> \n" .
  	"  </td> \n" .
		"</tr> \n";


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