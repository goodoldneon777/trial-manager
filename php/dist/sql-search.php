<?php
	$data = json_decode($_POST["input"]);


	$servername = getenv('server');
	$username = getenv('userRO');
	$password = getenv('passRO');
	$dbname = getenv('db');


	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	$whereStatement = "where 1=1 \n";
	$whereStatementBlank = true;

	if ($data->trialName != 'NULL') {
		$whereStatement .= "  and trial_name like '%" . substr($data->trialName, 1, strlen($data->trialName) - 2) . "%' \n";
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
		$whereStatement .= "  and trial_type = " . $data->trialType . " \n";
		$whereStatementBlank = false;
	}

	if ($data->changeType != 'NULL') {
		$whereStatement .= "  and change_type = " . $data->changeType . " \n";
		$whereStatementBlank = false;
	}



	$sql = 
		"select trial_name, unit, start_dt, end_dt, trial_seq \n" .
		"from trial \n";

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
			"    <th style=\"width:50%; text-align:center;\">Trial Name</th> \n" .
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
      	"  <td><a href=\"view.php?trialseq=" . $row["trial_seq"] . "\">" . $row["trial_name"] . "</a></td> \n" .
      	"  <td>" . $row["unit"] . "</td> \n" .
      	"  <td>" . date_format(date_create($row["start_dt"]), "m/d/Y") . "</td> \n" .
      	"  <td>" . date_format(date_create($row["end_dt"]), "m/d/Y") . "</td> \n" .
      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
      	"    <a href=\"view.php?trialseq=" . $row["trial_seq"] . "\">View</a> \n" .
      	"    | \n" .
      	"    <a href=\"comment.php?trialseq=" . $row["trial_seq"] . "\">Comment</a> \n" .
      	"  </td> \n" .
    		"</tr> \n";
    }
    $html .=
    	"  </tbody> \n" .
    	"</table> \n";
	} else {
    $html = "<div style=\"text-align:center; padding:10px;\">No trials found</div>";
	}


	$output = new stdClass();
	$output->html = $html;
	$output->sql = $sql;

	echo json_encode($output);


	$conn->close();
?>