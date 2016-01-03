<?php


	//Full path to this site's directory.
	define("SERVER_ROOT", dirname(__FILE__));


	//Path to this site's directory from the web server root.
	define("WEB_ROOT", substr(SERVER_ROOT, strlen($_SERVER["DOCUMENT_ROOT"])));






	// define("SERVER_ROOT", dirname(__FILE__));	//Deprecated.

	//For MAMP:
	// define("WEB_ROOT", "/" . basename(__DIR__));	//Deprecated.

	//For e3lapp:
	//define("WEB_ROOT", "/glw/" . basename(__DIR__));	//Deprecated.


?>
