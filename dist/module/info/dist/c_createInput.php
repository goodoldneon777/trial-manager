<?php
	
	function create_input($inputName, $value, $writeType) {
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
			select html_type, title, title_short, tooltip_info
			from param_input
			where name_id = '" . $inputName . "'
		";

		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$html_type = $row["html_type"];
		$title = $row["title"];
		$title_short = $row["title_short"];
		$tooltip = $row["tooltip_info"];

		if ($title_short === null) {
			$title_short = $title;
		}
		//>>>


		//<<< Handle readonly inputs.
		if ($writeType === 'readonly') {
			if ($html_type === 'textarea') {
				$html .=
					'<span class="elem-title hidden-xs">' . $title . '</span>' .
					'<span class="elem-title visible-xs" style="font-size:0.9em;">' . $title_short . '</span>' .
					'<textarea class="form-control" readonly>' . $value . '</textarea>' .
					'<span></span>';
			} else {
				$html .=
					'<span class="elem-title hidden-xs">' . $title . '</span>' .
					'<span class="elem-title visible-xs" style="font-size:0.9em;">' . $title_short . '</span>' .
					'<input class="form-control" type="text" readonly value="' . $value . '">' .
					'<span></span>';
			}

			$conn->close();

			return $html;
		}
		//>>>


		//<<< Handle different types of write inputs.
		if ($html_type === 'select') {	//Generate dropdown html.
			$sql = "
				select d.name_id, d.title, d.title_short, d.tooltip_info, o.order_num, o.option_value, o.option_text
				from param_input d
				inner join param_dropdown_options o
					on d.name_id = o.name_id
				where d.name_id = '" . $inputName . "'
				order by o.order_num asc
			";


			$result = $conn->query($sql);


			$count = 1;
			if ($result->num_rows > 0) {
				$valueInList = false;	//Initialize. $valueInList will be used later to determine whether $value isn't an option in the param_dropdown table.

				while($row = $result->fetch_assoc()) {
					$option_text = $row["option_text"];

					if ($count === 1) {
						$html .=
							'<span class="elem-title hidden-xs">' . $title . '</span>' .
							'<span class="elem-title visible-xs" style="font-size:0.9em;">' . $title_short . '</span>';

						if ($tooltip !== 'null') {
					  	$html .= '<select class="form-control" data-toggle="tooltip" title="' . $tooltip . '">';
						} else {
							$html .= '<select class="form-control">';
						}
					}


					if ($option_text === $value) {
						$valueInList = true;	//$value is an option in the param_dropdown table.
						$selected = 'selected';
					} else {
						$selected = '';
					}

					$html .= '<option ' . $selected . '>' . $option_text . '</option>';

					$count++;
				}

				if (!$valueInList  &&  $value !== "") {	//If $value isn't an option in the param_dropdown table, create a new option for it.
					$html .= '<option selected class="missing">' . $value . '</option>';
				}

				$html .= '</select>';
			} else {
				$html = 'none';
			}

			//End of 'select' html generation.
		} else if ($html_type === 'input') {	//Generate input html.

			if ($title_short === null) {
				$title_short = $title;
			}
			
			$html .=
				'<span class="elem-title hidden-xs">' . $title . '</span>' .
				'<span class="elem-title visible-xs" style="font-size:0.9em;">' . $title_short . '</span>';


			if ($tooltip !== 'null') {
		  	$html .= '<input class="form-control" type="text" value="' . $value . '" data-toggle="tooltip" title="' . $tooltip . '">';
			} else {
				$html .= '<input class="form-control" type="text" value="' . $value . '">';
			}


			$html .= '<span></span>';

			//End of 'input' html generation.
		} else if ($html_type === 'textarea') {	//Generate textarea html.

			if ($title_short === null) {
				$title_short = $title;
			}

			$html .=
				'<span class="elem-title hidden-xs">' . $title . '</span>' .
				'<span class="elem-title visible-xs" style="font-size:0.9em;">' . $title_short . '</span>';


			if ($tooltip !== 'null') {
		  	$html .= '<textarea class="form-control" data-toggle="tooltip" title="' . $tooltip . '">' . $value . '</textarea>';
			} else {
				$html .= '<textarea class="form-control">' . $value . '</textarea>';
			}


			$html .= '<span></span>';

			//End of 'input' html generation.
		}
		//>>>


		$conn->close();


		return $html;
	}

?>




