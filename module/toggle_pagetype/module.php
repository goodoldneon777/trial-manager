<?php

	function create_toggle_pagetype($pageType) {
		if ($pageType === 'trial') {
			$trialBtnClass = 'btn-primary';
			$groupBtnClass = 'btn-default';
		} else if ($pageType === 'group') {
			$trialBtnClass = 'btn-default';
			$groupBtnClass = 'btn-info';
		}

		$url = $_SERVER['REQUEST_URI'];
		$url = substr($url, 0, stripos($url, '?'));

		$html = '
			<a href="' . $url . '?type=trial" role="button" class="trial btn ' . $trialBtnClass . ' col-xs-6">Trial</a>
			<a href="' . $url . '?type=group" role="button" class="group btn ' . $groupBtnClass . ' col-xs-6">Group</a>
		';


		//Function continues...
?>


<div class="container noPad-xs">

	<div class="m-toggle_pagetype btn-group col-xs-12 noPad-xs" role="group" aria-label="...">
	  <?php echo $html; ?>
	</div>


	<!-- Horizontal break line -->
	<div class="col-xs-12"><hr></div>

</div>



<?php

	}

?>