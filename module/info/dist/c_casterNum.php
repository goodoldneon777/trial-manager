<?php
	
	function create_casterNum($pageType, $seq = null) {
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
			select distinct p.`name`, p.`order`, p.`value`, p.`text`, t.caster_num,
				case when p.`text` = t.caster_num then 'selected' else '' end as `selected`
			from param_dropdown p
			left outer join (
			    select caster_num
			    from " . $sql_table . "
			    where " . $sql_seq_field . " = '" . $seq . "'
			) t
				on 1 = 1
			where
				p.`name` = 'caster_num'
			order by p.`order` asc
			";

		$result = $conn->query($sql);


		if ($result->num_rows > 0) {
			$html .=
				'<span class="elem-title hidden-xs">Caster #</span>' .
			  '<span class="elem-title visible-xs" style="font-size:0.9em;">Caster</span>' .
		    '<select class="form-control" data-toggle="tooltip" title="Will this occur at only one Caster?">';
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



