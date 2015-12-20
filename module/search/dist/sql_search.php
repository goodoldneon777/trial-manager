<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$input = json_decode($_POST["input"]);
	$pageType = json_decode($_POST["pageType"]);


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	$whereStatement = "where 1=1 \n";	//Start where clause with a dummy 1=1 filter, allowing all future filters to start with "and".
	$whereStatementBlank = true;

	//Build name filter.
	if ($input->name != 'NULL') {
		$whereStatement .= "  and name like '%" . substr($input->name, 1, strlen($input->name) - 2) . "%' \n";
		$whereStatementBlank = false;
	}

	//Build start_dt filter.
	if ($input->startDate != 'NULL') {
		$whereStatement .= 
			"  and ( \n" .
			"    start_dt >= " . $input->startDate . " \n" .
			"    or end_dt >= " . $input->startDate . " \n" .
			"  ) \n";
		$whereStatementBlank = false;
	}

	//Build end_dt filter.
	if ($input->endDate != 'NULL') {
		$whereStatement .= 
			"  and ( \n" .
			"    start_dt <= " . $input->endDate . " + interval 1 day \n" .
			"    or end_dt <= " . $input->endDate . " + interval 1 day \n" .
			"  ) \n";
		$whereStatementBlank = false;
	}

	//Build unit filter.
	if ($input->unit != 'NULL') {
		$whereStatement .= "  and unit = " . $input->unit . " \n";
		$whereStatementBlank = false;
	}

	//Build goal_type filter.
	if ($input->goalType != 'NULL') {
		$whereStatement .= "  and goal_type = " . $input->goalType . " \n";
		$whereStatementBlank = false;
	}

	//Build change_type filter.
	if ($input->changeType != 'NULL') {
		$whereStatement .= "  and change_type = " . $input->changeType . " \n";
		$whereStatementBlank = false;
	}

	//Create the SELECT and FROM clauses depending on the pageType.
	if ($pageType === 'trial') {
		$sql = 
			"select name, unit, start_dt, end_dt, trial_seq as seq \n" .
			"from trial \n";
		$urlSeq = "trialseq=";
	} else if ($pageType === 'group') {
		$sql = 
			"select name, unit, start_dt, end_dt, group_seq as seq \n" .
			"from trial_group \n";
		$urlSeq = "groupseq=";
	}

	//Add the WHERE clause if it exists.
	if ($whereStatementBlank === false) {
		$sql .= " \n" . $whereStatement;
	}

	//Add the ORDER BY clause.
	$sql .= "order by start_dt desc; \n";



	//Run the query
	$result = $conn->query($sql);
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

	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      $html .= 
      	"<tr> \n" .
      	"  <td><a href=\"" . WEB_ROOT . "/view?" . $urlSeq . $row["seq"] . "\">" . $row["name"] . "</a></td> \n" .
      	"  <td>" . $row["unit"] . "</td> \n" .
      	"  <td>" . date_format(date_create($row["start_dt"]), "n/j/Y") . "</td> \n" .
      	"  <td>" . date_format(date_create($row["end_dt"]), "n/j/Y") . "</td> \n" .
      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
      	"    <a href=\"" . WEB_ROOT . "/comment?" . $urlSeq . $row["seq"] . "\">Comment</a> \n" .
      	"  </td> \n" .
    		"</tr> \n";
    }
	} else {
    $html .= '<tr><td colspan="5" style="text-align: center;">No search results</td></tr>';
	}

  $html .=
  	"  </tbody> \n" .
  	"</table> \n";


	$output = new stdClass();
	$output->html = $html;
	$output->sql = $sql;

	echo json_encode($output);


	$conn->close();
?>