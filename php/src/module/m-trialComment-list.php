<?php

	function create_trialComment_list($type, $trialSeq = null) {
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
			select comment_seq, comment_dt, comment_text
			from trial_comment
			where trial_seq = " . $trialSeq . " 
			order by comment_dt desc
			";


		$result = $conn->query($sql);
		$html = "";

		if ($result->num_rows > 0) {
			if ($type === 'readonly') {
				$html = 
					"<table class=\"table table-striped table-bordered\"> \n" .
					"  <thead style=\"text-align:center;\"> \n" .
					"    <th style=\"text-align:center; width:180px;\">Date</th> \n" .
					"    <th style=\"text-align:center;\">Comment</th> \n" .
					"  </thead> \n" .
					"  <tbody> \n";
			} else if ($type === 'write') {
				$html = 
					"<table class=\"table table-striped table-bordered\"> \n" .
					"  <thead style=\"text-align:center;\"> \n" .
					"    <th class=\"commentDate\">Date</th> \n" .
					"    <th class=\"commentText\">Comment</th> \n" .
					"    <th class=\"commentAction\">Actions</th> \n" .
					"  </thead> \n" .
					"  <tbody> \n";
			}

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
	      	$html .= "  <td class=\"commentDate\"> \n";
	      	$html .= "    <div class=\"input-group noPad-xs\"> \n";
	      	// $html .= "      <textarea class=\"form-control\" rows=\"1\">" . $date . "</textarea> \n";
	      	$html .= "      <input class=\"form-control\" rows=\"1\" value=\"" . $date . "\"";
	      	$html .= "    </div> \n";
	      	$html .= "  </td> \n";

	      	$html .= "  <td class=\"commentText\"> \n";
	      	$html .= "    <div class=\"input-group noPad-xs\"> \n";
	      	$html .= "      <textarea class=\"form-control\" rows=\"1\">" . $commentText . "</textarea> \n";
	      	$html .= "    </div> \n";
	      	$html .= "  </td> \n";

	      	$html .= "  <td class=\"commentAction\"> \n";
	      	$html .= "    <div class=\"noPad-xs\"> \n";
	      	$html .= "  		<a href=\"javascript: void(0)\" onclick=\"m_trialComment_list.deleteComment('" . $commentClass . "')\" class=\"delete\">Delete</a>";
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

	  <div class="content">
			<?php echo $html; ?>
		</div>

	</div>

</div>



<script src="js/dist/m-trialComment-list.min.js"></script>

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





