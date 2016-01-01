<?php
	
	function create_input($inputName) {
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


		//<<< Get input info.
		$sql = "
			select html_type, title, title_short, tooltip_search, tooltip_enable_flag
			from param_input
			where name_id = '" . $inputName . "'
		";


		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$html_type = $row["html_type"];
		$title = $row["title"];
		$tooltip = $row["tooltip_search"];
		$tooltip_enable_flag = $row["tooltip_enable_flag"];

		if ($title_short === null) {
			$title_short = $title;
		}
		//>>>



		//<<< Handle different types of write inputs.
		if ($html_type === 'select') {	//Generate dropdown html.
			$sql = "
				select d.name_id, d.title, d.title_short, d.tooltip_search, o.order_num, o.option_value, o.option_text
				from param_input d
				inner join param_dropdown_options o
					on d.name_id = o.name_id
				where d.name_id = '" . $inputName . "'
				order by o.order_num asc
			";


			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
				$html .= '<span class="elem-title">' . $title . '</span>';

				if ($tooltip !== 'null') {
					$html .= '<select class="form-control" data-toggle="tooltip" title="' . $tooltip . '">';
				}

				while($row = $result->fetch_assoc()) {
					$option_text = $row["option_text"];

					$html .= '<option>' . $option_text . '</option>';

					$count++;
				}

				$html .= '</select>';

			} else {
				$html = 'none';
			}

			//End of 'select' html generation.
		} else if ($html_type === 'input') {	//Generate input html.
			
			$html .= '<span class="elem-title">' . $title . '</span>';


			if ($tooltip !== 'null') {
		  	$html .= '<input class="form-control" type="text" data-toggle="tooltip" title="' . $tooltip . '">';
			} else {
				$html .= '<input class="form-control" type="text">';
			}


			$html .= '<span></span>';

			//End of 'input' html generation.
		}
		//>>>



		$conn->close();


		return $html;
	}

?>




