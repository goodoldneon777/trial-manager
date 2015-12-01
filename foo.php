<?php
	if (1===2) {
		ob_start();
?>


<div>Hello World!</div>


<?php
	$var = ob_get_contents();
	ob_end_clean();
} else $var = "nope";

	echo $var;
?>