<?php

	function prepForSQL($input) {
		/*
			-Recursive function that loops thru all elements in multidimensional arrays.
			-Wraps all non-array, non-null values in single quotes.
			-Null values are changed as non-wrapped strings.
		*/

		if (is_array($input)) {
			$output = array();

			foreach ($input as $value) {
				array_push($output, prepForSQL($value));	//Recursive call.
			}
		} elseif ($input === null) {
			$output = 'NULL';
		} else {
			//A database connection is required for real_scape_string() to work.
			$server = getenv("server");
			$userWR = getenv("userWR");
			$passWR = getenv("passWR");
			$db = getenv("db");
			$conn = new mysqli($server, $userWR, $passWR, $db);


			$input = $conn->real_escape_string($input);
			$output = "'" . $input . "'";


			$conn->close();
		}


		return $output;
	}

?>