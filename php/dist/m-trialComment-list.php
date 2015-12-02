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
			select comment_seq, comment_dt, comment_text
			from trial_comment
			where trial_seq = " . $trialSeq . " 
			order by comment_dt desc
			";


		$result = $conn->query($sql);
		$html = "";

		if ($result->num_rows > 0) {
			$html = 
				"<table class=\"table table-striped table-bordered\"> \n" .
				"  <thead style=\"text-align:center;\"> \n" .
				"    <th style=\"text-align:center; width:180px;\">Date</th> \n" .
				"    <th style=\"text-align:center;\">Comment</th> \n" .
				"  </thead> \n" .
				"  <tbody> \n";

	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	      $date = date_format(date_create($row["comment_dt"]), "n/j/Y H:i");
	      $commentText = $row["comment_text"];
	      $commentClass = "comment-" . $row["comment_seq"];
	      $html .= "<tr class=\"" . $commentClass . "\"> \n";

	      if ($type === 'readonly') {
	      	$commentText = str_replace( "\n","<br>", $commentText);

	      	$html .= "  <td>" . $date . "</td> \n";
	      	$html .= "  <td>" . $commentText . "</td> \n";
	      } else if ($type === 'write') {
	      	$html .= "  <td> \n";
	      	$html .= "    <div class=\"col-xs-12 noPad-xs\"> \n";
	      	$html .= "      <div class=\"commentDate input-group noPad-xs\"> \n";
	      	$html .= "        <textarea class=\"form-control\" rows=\"1\">" . $date . "</textarea> \n";
	      	$html .= "      </div> \n";
	      	$html .= "    </div> \n";
	      	$html .= "  </td> \n";
	      	$html .= "  <td> \n";

	      	$html .= "    <div class=\"col-xs-12 noPad-xs\"> \n";
	      	$html .= "      <div class=\"commentText input-group noPad-xs\"> \n";
	      	$html .= "        <textarea class=\"form-control\" rows=\"1\">" . $commentText . "</textarea> \n";
	      	$html .= "      </div> \n";
	      	$html .= "    </div> \n";
	      	$html .= "  </td> \n";
	      }
	    	$html .= "</tr> \n";
	    }
	    $html .=
	    	"  </tbody> \n" .
	    	"</table> \n";
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



<script src="js/dist/m-trialComment-list.min.js"></script>


<?php
		// ...function continues
	}
?>





