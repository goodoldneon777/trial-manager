<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$name = json_decode($_POST["name"]);


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 



	$sql = 
		"select name, unit, start_dt, end_dt, trial_seq as seq \n" .
		"from trial \n" .
		"where name like '%" . $name . "%' \n" .
		"order by start_dt desc \n";



	$result = $conn->query($sql);
	$html = "";

	if ($result->num_rows > 0) {
		$html = 
			"<table class=\"table table-striped table-bordered\"> \n" .
			"  <thead style=\"text-align:center;\"> \n" .
			"    <th></th> \n" .
			"    <th style=\"width:50%; text-align:center;\">Name</th> \n" .
			"    <th style=\"width:80px; text-align:center;\">Unit</th> \n" .
			"    <th style=\"text-align:center;\">Start Date</th> \n" .
			"    <th style=\"text-align:center;\">End Date</th> \n" .
			"  </thead> \n" .
			"  <tbody> \n";
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$seq = $row["seq"];
    	$name = $row["name"];
    	$start = $row["start_dt"];
    	$end = $row["end_dt"];

      $html .= 
      	"<tr> \n" .
      	"  <td><input type=\"checkbox\" value=\"" . $seq . "\"></td> \n" .
      	"  <td><a href=\"" . WEB_ROOT . "/view?trialseq=" . $seq . "\">" . $name . "</a> [" . $seq . "]</td> \n" .
      	"  <td>" . $row["unit"] . "</td> \n" .
      	"  <td>" . date_format(date_create($start), "n/j/Y") . "</td> \n" .
      	"  <td>" . date_format(date_create($end), "n/j/Y") . "</td> \n" .
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
	$output->debugSQL = $sql;

	echo json_encode($output);


	$conn->close();
?>