<?php
	function create_trialComment_list($type, $trialSeq = null) {
		$servername = "localhost";
		$username = "root";
		$password = "steel87";
		$dbname = "trial_mgr";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 


		$sql = "
			select insert_dt, comment_text
			from trial_comment
			where trial_seq = " . $trialSeq . " 
			order by comment_seq desc
			";


		$result = $conn->query($sql);
		$html = "";

		if ($result->num_rows > 0) {
			$html = "
				<table class=\"table table-striped table-bordered\">\n
					<thead style=\"text-align:center;\">\n
						<th style=\"text-align:center; width:180px;\">Date</th>\n
						<th style=\"text-align:center;\">Comment</th>\n
					</thead>\n
				";
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	      $date = date_format(date_create($row["insert_dt"]), "m/d/Y");
	      $commentText = $row["comment_text"];
	      $html .= "<tr> \n";

	      if ($type === 'readonly') {
	      	$html .= "  <td>" . $date . "</td> \n";
	      	$html .= "  <td>" . $commentText . "</td> \n";
	      } else if ($type === 'write') {
	      	$html .= "  <td> \n";
	      	$html .= "    <div class=\"col-xs-12 noPad-xs\"> \n";
	      	$html .= "      <div class=\"input-group noPad-xs\"> \n";
	      	$html .= "        <textarea class=\"form-control\">" . $date . "</textarea> \n";
	      	$html .= "      </div> \n";
	      	$html .= "    </div> \n";
	      	$html .= "  </td> \n";
	      	$html .= "  <td> \n";

	      	$html .= "    <div class=\"col-xs-12 noPad-xs\"> \n";
	      	$html .= "      <div class=\"input-group noPad-xs\"> \n";
	      	$html .= "        <textarea class=\"form-control\">" . $commentText . "</textarea> \n";
	      	$html .= "      </div> \n";
	      	$html .= "    </div> \n";
	      	$html .= "  </td> \n";
	      }
	    	$html .= "</tr> \n";
	    }
	    $html .= "</table> \n";
		} else {
	    $html = "<div style=\"text-align:center; padding:10px;\">No comments found</div> \n";
		}

		// Function continues...
?>


<div class="container noPad-xs">

	<div id="m-trialComment-list" class="panel panel-primary">
		<div class="panel-heading">
	    <h3 class="panel-title">
	    	Trial Comments
	    	<span class="description"></span>
	    </h3>
	  </div>
	<?php echo $html; ?>

	</div>

</div>



<?php
		// ...function continues
	}
?>





