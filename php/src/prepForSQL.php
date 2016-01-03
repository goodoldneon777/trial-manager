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
			$output = "'" . $input . "'";
		}


		return $output;
	}

?>