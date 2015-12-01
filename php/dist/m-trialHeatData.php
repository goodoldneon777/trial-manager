<?php
	function create_trialHeatData($type, $trialSeq = '') {


		if ($type === "write") {
			$description = "(optional)";
		} else {
			$description = "";
		}

		// Function continues...
?>


<div class="container noPad-xs hidden-xs">

	<div id="m-trialHeatData" class="panel panel-primary">
		<div class="panel-heading">
	    <h3 class="panel-title">Trial Data <span class="description"><?php echo $description ?></span></h3>
	  </div>

	  <div class="dataTable handsontable"></div>

	</div>

</div>



<script src="js/dist/m-trialHeatData.min.js"></script>

<script>
	m_trialHeatData.create( <?php echo "'" . $type . "'"; ?> );
	m_trialHeatData.populate( <?php echo "'" . $trialSeq . "'"; ?> );
</script>




<?php
		// ... function continues
	}
?>