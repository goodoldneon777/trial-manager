<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$data = json_decode($_POST["input"]);


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	$whereStatement = "where 1=1 \n";
	$whereStatementBlank = true;

	if ($data->trialName != 'NULL') {
		$whereStatement .= "  and name like '%" . substr($data->trialName, 1, strlen($data->trialName) - 2) . "%' \n";
		$whereStatementBlank = false;
	}

	if ($data->startDate != 'NULL') {
		$whereStatement .= 
			"  and ( \n" .
			"    start_dt >= " . $data->startDate . " \n" .
			"    or end_dt >= " . $data->startDate . " \n" .
			"  ) \n";
		$whereStatementBlank = false;
	}

	if ($data->endDate != 'NULL') {
		$whereStatement .= 
			"  and ( \n" .
			"    start_dt <= " . $data->endDate . " + interval 1 day \n" .
			"    or end_dt <= " . $data->endDate . " + interval 1 day \n" .
			"  ) \n";
		$whereStatementBlank = false;
	}

	if ($data->unit != 'NULL') {
		$whereStatement .= "  and unit = " . $data->unit . " \n";
		$whereStatementBlank = false;
	}

	if ($data->trialType != 'NULL') {
		$whereStatement .= "  and goal_type = " . $data->trialType . " \n";
		$whereStatementBlank = false;
	}

	if ($data->changeType != 'NULL') {
		$whereStatement .= "  and change_type = " . $data->changeType . " \n";
		$whereStatementBlank = false;
	}



	$sql = 
		"select name, unit, start_dt, end_dt, group_seq \n" .
		"from trial_group \n";

	if ($whereStatementBlank === false) {
		$sql .= " \n" . $whereStatement;
	}


	$sql .= "order by start_dt desc \n";


	$result = $conn->query($sql);
	$html = "";

	if ($result->num_rows > 0) {
		$html = 
			"<table class=\"table table-striped table-bordered\"> \n" .
			"  <thead style=\"text-align:center;\"> \n" .
			"    <th style=\"width:50%; text-align:center;\">Name</th> \n" .
			"    <th style=\"width:80px; text-align:center;\">Unit</th> \n" .
			"    <th style=\"text-align:center;\">Start Date</th> \n" .
			"    <th style=\"text-align:center;\">End Date</th> \n" .
			"    <th class=\"hidden-xs\" style=\"text-align:center;\">Actions</th> \n" .
			"  </thead> \n" .
			"  <tbody> \n";
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $html .= 
      	"<tr> \n" .
      	"  <td><a href=\"view.php?groupseq=" . $row["group_seq"] . "\">" . $row["name"] . "</a></td> \n" .
      	"  <td>" . $row["unit"] . "</td> \n" .
      	"  <td>" . date_format(date_create($row["start_dt"]), "n/j/Y") . "</td> \n" .
      	"  <td>" . date_format(date_create($row["end_dt"]), "n/j/Y") . "</td> \n" .
      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
      	"    <a href=\"view.php?groupseq=" . $row["group_seq"] . "\">View</a> \n" .
      	"    | \n" .
      	"    <a href=\"comment.php?groupseq=" . $row["group_seq"] . "\">Comment</a> \n" .
      	"  </td> \n" .
    		"</tr> \n";
    }
    $html .=
    	"  </tbody> \n" .
    	"</table> \n";
	} else {
    $html = "<div style=\"text-align:center; padding:10px;\">No groups found</div>";
	}


	$output = new stdClass();
	$output->html = $html;
	$output->sql = $sql;

	echo json_encode($output);


	$conn->close();
?>