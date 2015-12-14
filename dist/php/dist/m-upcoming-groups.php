<?php
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


	$sql = "
		select name, unit, start_dt, end_dt, group_seq as seq
		from trial_group
		where
			start_dt between curdate() + interval 1 day and curdate() + interval 7 day
		order by start_dt desc
		";


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
      $html .= 
      	"<tr> \n" .
      	"  <td><a href=\"view.php?groupseq=" . $row["seq"] . "\">" . $row["name"] . "</a></td> \n" .
      	"  <td>" . $row["unit"] . "</td> \n" .
      	"  <td>" . date_format(date_create($row["start_dt"]), "m/d/Y") . "</td> \n" .
      	"  <td>" . date_format(date_create($row["end_dt"]), "m/d/Y") . "</td> \n" .
      	"  <td class=\"hidden-xs\" style=\"text-align:center;\"> \n" .
      	"    <a href=\"view.php?groupseq=" . $row["seq"] . "\">View</a> \n" .
      	"    | \n" .
      	"    <a href=\"comment.php?groupseq=" . $row["seq"] . "\">Comment</a> \n" .
      	"  </td> \n" .
    		"</tr> \n";
    }
    $html .=
    	"  </tbody> \n" .
    	"</table> \n";
	} else {
    $html = "<div style=\"text-align:center; padding:10px;\">No groups found.</div>";
	}

?>



<div id="m-recent-trials" class="panel panel-info">
	<div class="panel-heading">
    <h3 class="panel-title">
    	Upcoming Groups
    	<span class="description">(next 7 days)</span>
    </h3>
  </div>
<?php echo $html; ?>

</div>












