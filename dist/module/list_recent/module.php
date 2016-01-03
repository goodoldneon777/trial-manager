<?php

	function create_recent($pageType) {
		if ($pageType === 'trial') {
			$sql = "
				select name as name, unit, start_dt, end_dt, trial_seq as seq
				from trial
				where
					end_dt >= curdate() - interval 60 day
					and end_dt < curdate()
				order by end_dt desc, start_dt desc
				";
			$module_class = "\"m_recent panel panel-primary\"";
			$module_title = "Recent Trials";
			$module_urlSeq = "trialseq=";
		} else if ($pageType === 'group') {
			$sql = "
				select name, unit, start_dt, end_dt, group_seq as seq
				from trial_group
				where
					end_dt >= curdate() - interval 60 day
					and end_dt < curdate()
				order by end_dt desc, start_dt desc
				";
			$module_class = "\"m_recent panel panel-info\"";
			$module_title = "Recent Groups";
			$module_urlSeq = "groupseq=";
		}

		$server = getenv("server");
		$userWR = getenv("userWR");
		$passWR = getenv("passWR");
		$db = getenv("db");


		// Create connection
		$conn = new mysqli($server, $userWR, $passWR, $db);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		} 


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
	    	$seq = $row["seq"];
	      $html .= 
	      	"<tr> \n" .
	      	"  <td><a href=\"" . WEB_ROOT . "/view?" . $module_urlSeq . $seq . "\">" . $row["name"] . "</a></td> \n" .
	      	"  <td>" . $row["unit"] . "</td> \n" .
	      	"  <td>" . date_format(date_create($row["start_dt"]), "m/d/Y") . "</td> \n" .
	      	"  <td>" . date_format(date_create($row["end_dt"]), "m/d/Y") . "</td> \n" .
	      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
	      	"    <a href=\"" . WEB_ROOT . "/comment?" . $module_urlSeq . $seq . "\">Comment</a> \n" .
	      	"  </td> \n" .
	    		"</tr> \n";
	    }
	    $html .=
	    	"  </tbody> \n" .
	    	"</table> \n";
		} else {
	    $html = "<div style=\"text-align:center; padding:10px;\">No trials found.</div>";
		}


	//Function continues...
?>



<div class= <?php echo $module_class; ?> >
	<div class="panel-heading">
    <h3 class="panel-title">
    	<?php echo $module_title; ?>
    	<span class="description">(previous 60 days)</span>
    </h3>
  </div>
<?php echo $html; ?>

</div>



<?php

	}

?>








