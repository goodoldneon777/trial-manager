<?php
	function create_heatData_trial($type, $trialSeq = '') {


		if ($type === "write") {
			$description = "(optional)";
		} else {
			$description = "";
		}

		// Function continues...
?>


<div class="container noPad-xs hidden-xs">

	<div class="m-heatData-trial panel panel-primary">
		<div class="panel-heading">
	    <h3 class="panel-title">Trial Data <span class="description"><?php echo $description ?></span></h3>
	  </div>

	  <div class="dataTable handsontable"></div>

	</div>

</div>



<script src="js/dist/m-heatData-trial.min.js"></script>

<script>
	m_heatData_trial.create( <?php echo "'" . $type . "'"; ?> );
	m_heatData_trial.populate( <?php echo "'" . $trialSeq . "'"; ?> );
</script>




<?php
		// ... function continues
	}
?>