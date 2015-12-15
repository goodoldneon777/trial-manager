<?php

	function create_childList_group($type, $seq = 0) {
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
			select a.trial_seq, a.trial_name, b.unit, a.trial_start_dt, a.trial_end_dt
			from trial_group_child a
			inner join trial b
				on a.trial_seq = b.trial_seq
			where a.group_seq = " . $seq . " 
			order by a.trial_end_dt desc
			";


		$result = $conn->query($sql);
		$html = "";

		if ($result->num_rows > 0) {
			$html_tableStart = 
				"<table class=\"childTable table table-striped table-bordered\"> \n" .
				"  <thead style=\"text-align:center;\"> \n" .
				"    <th style=\"width:50%; text-align:center;\">Trial Name</th> \n" .
				"    <th style=\"width:80px; text-align:center;\">Unit</th> \n" .
				"    <th style=\"text-align:center;\">Start Date</th> \n" .
				"    <th style=\"text-align:center;\">End Date</th> \n" .
				"    <th class=\"hidden-xs\" style=\"text-align:center;\">Actions</th> \n" .
				"  </thead> \n" .
				"  <tbody> \n";
			$html = $html_tableStart;

	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	$seq = $row["trial_seq"];
	    	$rowClass = "seq-" . $seq;
	    	$name = $row["trial_name"];
	    	$unit = $row["unit"];
	    	$start = $row["trial_start_dt"];
	    	$end = $row["trial_end_dt"];

	      if ($type === 'readonly') {
	      	$html .= 
		      	"<tr class=\"seq-" . $seq . "\"> \n" .
		      	"  <td><a href=\"view.php?trialseq=" . $seq . "\">" . $name . "</a> [" . $seq . "]</td> \n" .
		      	"  <td>" . $unit . "</td> \n" .
		      	"  <td>" . date_format(date_create($start), "m/d/Y") . "</td> \n" .
		      	"  <td>" . date_format(date_create($end), "m/d/Y") . "</td> \n" .
		      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
		      	"    <a href=\"view.php?trialseq=" . $seq . "\">View</a> \n" .
		      	"    | \n" .
		      	"    <a href=\"comment.php?trialseq=" . $seq . "\">Comment</a> \n" .
		      	"  </td> \n" .
		    		"</tr> \n";
	      } else if ($type === 'write') {
	      	$html .= 
		      	"<tr class=\"seq-" . $seq . "\"> \n" .
		      	"  <td><a href=\"view.php?trialseq=" . $seq . "\">" . $name . "</a> [" . $seq . "]</td> \n" .
		      	"  <td>" . $unit . "</td> \n" .
		      	"  <td>" . date_format(date_create($start), "m/d/Y") . "</td> \n" .
		      	"  <td>" . date_format(date_create($end), "m/d/Y") . "</td> \n" .
		      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
		      	"    <span class=\"removeTrialLink\"> \n" .
		      	"      <a href=\"javascript: void(0)\" onclick=\"m_childList_group.removeClick('" . $rowClass . "')\" data-toggle=\"tooltip\" title=\"Only unlinks the trial. Doesn't delete it from the database.\">Remove</a> \n" .
		      	"    </span> \n" .
		      	"  </td> \n" .
		    		"</tr> \n";
	      }
	    	$html .= "</tr> \n";
	    }

	    $html_tableEnd =
	    	"  </tbody> \n" .
	    	"</table> \n";
	    $html .= $html_tableEnd;
		} else {
	    $html = "<div style=\"text-align:center; padding:10px;\">No trials found</div>";
		}



		if ($type === 'readonly') {
			$html_addTrialBtn = '';
		} else if ($type === 'write') {
			$html_addTrialBtn = '<button type="button" class="addTrialBtn btn btn-large btn-success" data-toggle="tooltip" title="Add a trial to this group.">Add Trials</button>';
		}


		// Function continues...
?>



<div class="container noPad-xs">

	<div class="m-childList-group panel panel-info">
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

<!-- 			<div class="panel panel-info">
			  <div class="panel-body">
			    Panel content
			  </div>
			</div> -->

		<!-- </div> -->

	</div>

</div>



<!-- <script src="js/dist/m-childList_group.min.js"></script> -->

<script>
  $(document).ready(function(){
    $('.delete').click(function(e){
       e.preventDefault();
    })
  });
</script>


<?php

		// ...function continues
	}
?>




<script src="js/dist/m-childList-group.min.js"></script>
