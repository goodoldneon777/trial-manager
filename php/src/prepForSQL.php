<?php

	function prepForSQL($input) {
		/*
			-Accepts objects, arrays, numbers, strings, and null values.
			-Returns an output that is identical to the input (object structure, array structure, etc.), but with all child numbers, strings, and null values prepped for SQL.
			-Wraps all numbers and strings with single quotes.
			-Converts all null values to strings (not wrapped with single quotes).
			-All numbers and strings are sanitized using real_escape_string().
		*/


		if (is_object($input)) {
			$output = new stdClass();

			foreach($input as $key => $value) {
		  	$output->$key = prepForSQL($value);	//Recursive call.
			}
		} elseif (is_array($input)) {
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


			$output = strval($input);
			$output = $conn->real_escape_string($output);
			$output = "'" . $output . "'";
		

			$conn->close();
		}


		return $output;
	}



	function removeStringWrap($input) {
		$output = $input;
		$output = ltrim($output, "'");
		$output = rtrim($output, "'");

		return $output;
	}

?>