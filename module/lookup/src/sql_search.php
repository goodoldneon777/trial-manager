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


	//Create the pseudo subquery
	$sqlQueryPseudo = '';
	if (count($input) > 0) {
		foreach($input as $key=>$row) {
			if ($key > 0) {
				$sqlQueryPseudo .= "union \n";
			}

			$sqlQueryPseudo .= "select '" . $row[0] . "' as ht_num, '" . $row[1] . "' as tap_yr \n";
		}
	}


	//Create the main query
	if ($pageType === 'trial') {
		$sql = 
			"select p.ht_num as input_id, t.name, t.unit, t.start_dt, t.end_dt, t.trial_seq as seq \n" .
			"from ( \n" .
			$sqlQueryPseudo .
			") p \n" .
			"left outer join trial_ht h \n" .
			"  on p.ht_num = cast(h.ht_num as char(10)) \n" .
			"    and p.tap_yr = cast(h.tap_yr as char(10)) \n" .
			"left outer join trial t \n" .
			"  on h.trial_seq = t.trial_seq \n";
		$urlSeq = "trialseq=";
	} else if ($pageType === 'group') {
		$sql = 
			"select p.ht_num as input_id, t.name, t.unit, t.start_dt, t.end_dt, t.group_seq as seq \n" .
			"from ( \n" .
			$sqlQueryPseudo .
			") p \n" .
			"left outer join trial_ht h \n" .
			"  on p.ht_num = cast(h.ht_num as char(10)) \n" .
			"    and p.tap_yr = cast(h.tap_yr as char(10)) \n" .
			"left outer join trial_group_child c \n" .
			"  on h.trial_seq = c.trial_seq \n" .
			"left outer join trial_group t \n" .
			"  on c.group_seq = t.group_seq \n" .
			"where \n" .
  		"  t.group_seq is not null \n" .
  		"  or ( \n".
    	"    p.ht_num is not null \n" .
    	"    and h.trial_seq is null \n" .
  		"  ) \n";
		$urlSeq = "groupseq=";
	}


	//Run the query
	$result = $conn->query($sql);


	//Start the results table HTML.
	$html = 
			"<table class=\"table table-striped table-bordered\"> \n" .
			"  <thead style=\"text-align:center;\"> \n" .
			"    <th style=\"text-align:center;\">ID</th> \n" .
			"    <th style=\"width:50%; text-align:center;\">Name</th> \n" .
			"    <th style=\"text-align:center;\">Unit</th> \n" .
			"    <th style=\"text-align:center;\">Start Date</th> \n" .
			"    <th style=\"text-align:center;\">End Date</th> \n" .
			"  </thead> \n" .
			"  <tbody> \n";


	//If there are results from the query...
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$id = $row["input_id"];
    	$seq = $row["seq"];
    	$name = $row["name"];
    	$unit = $row["unit"];
    	$startDate = $row["start_dt"];
    	$endDate = $row["end_dt"];

    	if ($name) {
    		$name = "<a href=\"" . WEB_ROOT . "/view?" . $urlSeq . $seq . "\">" . $name . "</a>";
    	} else {
    		$name = "No results";
    	}

    	if ($startDate) {
    		$startDate = date_format(date_create($startDate), "n/j/Y");
    	}

    	if ($endDate) {
    		$endDate = date_format(date_create($endDate), "n/j/Y");
    	}


      $html .= 
      	"<tr> \n" .
      	"  <td>" . $id . "</td> \n" .
      	"  <td>" . $name . "</td> \n" .
      	"  <td>" . $unit . "</td> \n" .
      	"  <td>" . $startDate . "</td> \n" .
      	"  <td>" . $endDate . "</td> \n" .
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