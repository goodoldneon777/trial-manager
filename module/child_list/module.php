<?php

	function create_child_list($writeType, $seq = 0) {
		$server = getenv('server');
		$userWR = getenv('userWR');
		$passWR = getenv('passWR');
		$db = getenv('db');
		
		// Create connection
		$conn = new mysqli($server, $userWR, $passWR, $db);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 


		$sql = "
			select trial_seq as seq, trial_name as name, trial_unit as unit, trial_start_dt as start_dt, trial_end_dt as end_dt, deleted_flag
			from trial_group_child a
			where group_seq = " . $seq . " 
			order by trial_end_dt desc
			";


		$result = $conn->query($sql);
		$html = 
			"<table class=\"childTable table table-striped table-bordered\"> \n" .
			"  <thead style=\"text-align:center;\"> \n" .
			"    <th style=\"width:50%; text-align:center;\">Trial Name</th> \n" .
			"    <th style=\"width:80px; text-align:center;\">Unit</th> \n" .
			"    <th style=\"text-align:center;\">Start Date</th> \n" .
			"    <th style=\"text-align:center;\">End Date</th> \n" .
			"    <th style=\"text-align:center;\">Actions</th> \n" .
			"  </thead> \n" .
			"  <tbody> \n";

		if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	$seq = $row["seq"];
	    	$rowClass = "seq-" . $seq;
	    	$name = $row["name"];
	    	$unit = $row["unit"];
	    	$start = $row["start_dt"];
	    	$end = $row["end_dt"];
	    	$status = "";

	    	if ($row["deleted_flag"] === "1") {
	    		$rowClass .= " deleted";
	    		$status = "[DELETED]";
	    	}

	      if ($writeType === 'readonly') {
	      	$html .= 
		      	"<tr class=\"" . $rowClass . "\"> \n" .
		      	"  <td><a href=\"" . WEB_ROOT . "\\view?trialseq=" . $seq . "\">" . $name . "</a> " . $status . "</td> \n" .
		      	"  <td>" . $unit . "</td> \n" .
		      	"  <td>" . date_format(date_create($start), "n/j/Y") . "</td> \n" .
		      	"  <td>" . date_format(date_create($end), "n/j/Y") . "</td> \n" .
		      	"  <td class=\"actions hidden-xs\"> \n" .
		      	"    <a href=\"" . WEB_ROOT . "\\comment?trialseq=" . $seq . "\">Comment</a> \n" .
		      	"  </td> \n" .
		    		"</tr> \n";
	      } else if ($writeType === 'write') {
	      	$html .= 
		      	"<tr class=\"" . $rowClass . " foo\"> \n" .
		      	"  <td><a href=\"" . WEB_ROOT . "\\view?trialseq=" . $seq . "\">" . $name . "</a> [" . $seq . "] " . $status . "</td> \n" .
		      	"  <td>" . $unit . "</td> \n" .
		      	"  <td>" . date_format(date_create($start), "n/j/Y") . "</td> \n" .
		      	"  <td>" . date_format(date_create($end), "n/j/Y") . "</td> \n" .
		      	"  <td class=\"actions\"> \n" .
		      	"      <a href=\"javascript: void(0)\" class=\"remove\" data-toggle=\"tooltip\" title=\"Only unlinks the trial. Doesn't delete it from the database.\">Remove</a> \n" .
		      	"  </td> \n" .
		    		"</tr> \n";
	      }
	    	$html .= "</tr> \n";
	    }

		} else {
	    $html .= '<tr class="noResults"><td colspan="5" style="text-align:center; padding:10px;">No trials found</td></tr>';
		}

		$html .=
    	"  </tbody> \n" .
    	"</table> \n";


		if ($writeType === 'readonly') {
			$html_addTrialBtn = '';
		} else if ($writeType === 'write') {
			$html_addTrialBtn = '<button type="button" class="addTrialBtn btn btn-large btn-success" data-toggle="tooltip" title="Add a trial to this group.">Add Trials</button>';
		}


		// Function continues...
?>


<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/child_list/dist/style.css"; ?>">


<div class="container noPad-xs">

	<div class="m_child_list panel panel-info">
		<div class="panel-heading">
	    <h3 class="panel-title">
	    	Trials In This Group
	    	<span class="description"></span>
	    </h3>
	  </div>

	  <div class="content">
			<?php echo $html; ?>
		</div>

		<div style="text-align:center;">
			<?php echo $html_addTrialBtn; ?>
		</div>

	</div>

</div>



<script src="<?php echo WEB_ROOT . "/module/child_list/dist/script.min.js"; ?>"></script>



<?php

		// ...function continues
	}
?>



