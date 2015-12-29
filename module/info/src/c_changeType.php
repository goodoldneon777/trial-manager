<?php
	
	function create_changeType($pageType, $seq = null) {
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
			select distinct p.`name`, p.`order`, p.`value`, p.`text`, t.change_type,
				case when p.`text` = t.change_type then 'selected' else '' end as `selected`
			from param_dropdown p
			left outer join (
			    select change_type
			    from " . $sql_table . "
			    where " . $sql_seq_field . " = '" . $seq . "'
			) t
				on 1 = 1
			where
				p.`name` = 'change_type'
			order by p.`order` asc
			";

		$result = $conn->query($sql);


		if ($result->num_rows > 0) {
			$html .=
				'<span class="elem-title">Change Type</span>' .
		  	'<select class="form-control" data-toggle="tooltip" title="In general, what is this changing?">';
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




