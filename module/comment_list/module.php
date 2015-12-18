<?php

	function create_comment_list($writeType, $pageType, $seq = null) {
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


		if ($pageType === 'trial') {
			$sql = "
				select comment_seq, comment_dt, comment_text
				from trial_comment
				where trial_seq = " . $seq . " 
				order by comment_dt desc
				";
		} else if ($pageType === 'group') {
			$sql = "
				select comment_seq, comment_dt, comment_text
				from trial_group_comment
				where group_seq = " . $seq . " 
				order by comment_dt desc
				";
		}


		$result = $conn->query($sql);
		if ($writeType === 'readonly') {
			$html = 
				"<table class=\"table table-striped table-bordered\"> \n" .
				"  <thead style=\"text-align:center;\"> \n" .
				"    <th style=\"text-align:center; width:180px;\">Date</th> \n" .
				"    <th style=\"text-align:center;\">Comment</th> \n" .
				"  </thead> \n" .
				"  <tbody> \n";
			$tableCols = 2;
		} else if ($writeType === 'write') {
			$html = 
				"<table class=\"table table-striped table-bordered\"> \n" .
				"  <thead style=\"text-align:center;\"> \n" .
				"    <th class=\"commentDate\">Date</th> \n" .
				"    <th class=\"commentText\">Comment</th> \n" .
				"    <th class=\"commentAction\">Actions</th> \n" .
				"  </thead> \n" .
				"  <tbody> \n";
			$tableCols = 3;
		}

		if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	      $date = date_format(date_create($row["comment_dt"]), "n/j/Y H:i");
	      $commentText = $row["comment_text"];
	      $commentClass = "seq-" . $row["comment_seq"];
	      $html .= "<tr class=\"" . $commentClass . "\"> \n";

	      if ($writeType === 'readonly') {
	      	$commentText = str_replace( "\n","<br>", $commentText);

	      	$html .= "  <td>" . $date . "</td> \n";
	      	$html .= "  <td>" . $commentText . "</td> \n";
	      } else if ($writeType === 'write') {
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

	      	$html .= "  <td class=\"actions\"> \n";
	      	$html .= "    <div class=\"noPad-xs\"> \n";
	      	$html .= "  		<a href=\"javascript: void(0)\" class=\"delete\">Delete</a>";
	      	$html .= "    </div> \n";
	      	$html .= "  </td> \n";
	      }
	    	$html .= "</tr> \n";
	    }
	    
		} else {
	    $html .= '<tr class="noResults"><td colspan="' . $tableCols . '" style="text-align:center; padding:10px;">No comments found</td></tr>';
		}

		$html .=
    	"  </tbody> \n" .
    	"</table> \n";


		if ($pageType === 'trial') {
			$moduleClass = '"m_comment_list panel panel-primary"';
			$moduleTitle = 'Trial Comments';
		} else if ($pageType === 'group') {
			$moduleClass = '"m_comment_list panel panel-info"';
			$moduleTitle = 'Group Comments';
		}


		// Function continues...
?>

<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/comment_list/dist/style.css"; ?>">


<div class="container noPad-xs">

	<div class=<?php echo $moduleClass; ?> >
		<div class="panel-heading">
	    <h3 class="panel-title">
	    	<?php echo $moduleTitle; ?>
	    	<span class="description"></span>
	    </h3>

	  </div>

	  <div class="content">
			<?php echo $html; ?>
		</div>

	</div>

</div>


<script src="<?php echo WEB_ROOT . "/module/comment_list/dist/script.min.js"; ?>"></script>



<?php
		// ...function continues
	}
?>





