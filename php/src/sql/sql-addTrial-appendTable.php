<?php
	$server = getenv("server");
	$userWR = getenv("userWR");
	$passWR = getenv("passWR");
	$db = getenv("db");

	
	$seqCSV = json_decode($_POST["seqCSV"]);


	// Create connection
	$conn = new mysqli($server, $userWR, $passWR, $db);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 



	$sql = 
		"select trial_name, unit, start_dt, end_dt, trial_seq \n" .
		"from trial \n" .
		"where trial_seq in (" . $seqCSV . ") \n" .
		"order by start_dt desc \n";



	$result = $conn->query($sql);
	$html = "";

	if ($result->num_rows > 0) {

    // output data of each row
    while($row = $result->fetch_assoc()) {
      $date = date_format(date_create($row["comment_dt"]), "n/j/Y H:i");
    	$seq = $row["trial_seq"];
	    $rowClass = "seq-" . $seq;
    	$name = $row["trial_name"];
    	$unit = $row["unit"];
    	$start = $row["start_dt"];
    	$end = $row["end_dt"];


    	$html .= 
      	"<tr class=\"seq-" . $seq . "\"> \n" .
      	"  <td><a href=\"view.php?trialseq=" . $seq . "\">" . $name . "</a> [" . $seq . "]</td> \n" .
      	"  <td>" . $unit . "</td> \n" .
      	"  <td>" . date_format(date_create($start), "m/d/Y") . "</td> \n" .
      	"  <td>" . date_format(date_create($start), "m/d/Y") . "</td> \n" .
      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
      	"    <a href=\"javascript: void(0)\" onclick=\"m_childList_group.removeClick('" . $rowClass . "')\" data-toggle=\"tooltip\" title=\"Only unlinks the trial. Doesn't delete it from the database.\">Remove</a> \n" .
      	"  </td> \n" .
    		"</tr> \n";
    }

	}


	$output = new stdClass();
	$output->html = $html;
	$output->debugSQL = $sql;

	echo json_encode($output);


	$conn->close();
?>