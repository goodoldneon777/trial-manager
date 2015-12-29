<?php
	
	function create_goalType($pageType, $seq = null) {
		$server = getenv('server');
		$userWR = getenv('userWR');
		$passWR = getenv('passWR');
		$db = getenv('db');

		$html = '';


		if ($pageType === 'trial') {
			$sql_table = 'trial';
			$sql_seq_field = 'trial_seq';
		} else if ($pageType === 'group') {
			$sql_table = 'trial_group';
			$sql_seq_field = 'group_seq';
		}
		

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
			    from " . $sql_table . "
			    where " . $sql_seq_field . " = '" . $seq . "'
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

?>




