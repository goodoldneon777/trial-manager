<?php
	$servername = "localhost";
	$username = "trial_mgr_ro";
	$password = "manofsteel";
	$dbname = "trial_mgr";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 


	$sql = "
		select trial_name, unit, start_dt, end_dt, trial_seq
		from trial
		where
			start_dt <= curdate()
			and end_dt >= curdate()
		order by start_dt desc
		";


	$result = $conn->query($sql);
	$html = "";

	if ($result->num_rows > 0) {
		$html = "
			<table class=\"table table-striped table-bordered\">\n
				<thead style=\"text-align:center;\">\n
					<th style=\"width:50%; text-align:center;\">Trial Name</th>\n
					<th style=\"width:80px; text-align:center;\">Unit</th>\n
					<th style=\"text-align:center;\">Start Date</th>\n
					<th style=\"text-align:center;\">End Date</th>\n
					<th style=\"text-align:center;\">Actions</th>\n
				</thead>\n
			";
    // output data of each row
    while($row = $result->fetch_assoc()) {
      // echo "id: " . $row["trial_name"]. " - Name: " . $row["start_dt"]. " " . $row["end_dt"]. "<br>";
      $html .= "
      	<tr>\n
      		<td><a href=\"view.php?trialseq=" . $row["trial_seq"] . "\">" . $row["trial_name"] . "</a></td>\n
      		<td>" . $row["unit"] . "</td>\n
      		<td>" . date_format(date_create($row["start_dt"]), "m/d/Y") . "</td>\n
      		<td>" . date_format(date_create($row["end_dt"]), "m/d/Y") . "</td>\n
      		<td style=\"text-align:center;\">
      			<a href=\"view.php?trialseq=" . $row["trial_seq"] . "\">View</a>
      			|
      			<a href=\"comment.php?trialseq=" . $row["trial_seq"] . "\">Comment</a></td>\n
    		</tr>\n";
    }
    $html .= "</table>";
	} else {
    $html = "<div style=\"text-align:center; padding:10px;\">No trials found</div>";
	}

?>



<div id="m-recent-trials" class="panel panel-primary">
	<div class="panel-heading">
    <h3 class="panel-title">
    	Ongoing Trials
    	<span class="description"></span>
    </h3>
  </div>
<?php echo $html; ?>

</div>












