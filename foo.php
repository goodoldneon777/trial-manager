<?php
	
	function create_goalType($seq = null) {
		$server = getenv('server');
		$userWR = getenv('userWR');
		$passWR = getenv('passWR');
		$db = getenv('db');

		$html = '';

		// Create connection
		$conn = new mysqli($server, $userWR, $passWR, $db);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		} 


		$sql = "
			select distinct p.`name`, p.`order`, p.`value`, p.`text`, t.goal_type,
				case when p.`text` = t.goal_type then 'selected' else '' end as `selected`
			from param_dropdown p
			left outer join (
			    select goal_type
			    from trial
			    where trial_seq = '" . $seq . "'
			) t
				on 1 = 1
			where
				p.`name` = 'goal_type'
			order by p.`order` asc
			";

		$result = $conn->query($sql);


		if ($result->num_rows > 0) {
			$html .=
				'<span class="elem-title">Goal Type</span>' .
		  	'<select class="form-control" data-toggle="tooltip" title="In general, what is this trying to improve?">';
			while($row = $result->fetch_assoc()) {
				$text = $row["text"];
				$selected = $row["selected"];

				$html .= '<option ' . $selected . '>' . $text . '</option>';
			}
			$html .= '</select>';
		} else {
			$html = 'none';
		}

		return $html;
	}


	// $html_goalType = create_goalType(48);

	// echo $html_goalType;
?>




