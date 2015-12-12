<?php

	function create_childList_group($type, $seq = null) {
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
			if ($type === 'readonly') {
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
			} else if ($type === 'write') {
				$html = '{replace}';
			}

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





