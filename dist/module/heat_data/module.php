<?php
	function create_heat_data($writeType, $seq = '') {


		if ($writeType === "write") {
			$description = "(optional)";
		} else {
			$description = "";
		}

		// Function continues...
?>


<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/heat_data/dist/style.min.css"; ?>">


<div class="container noPad-xs hidden-xs">

	<div class="m_heat_data panel panel-primary">
		<div class="panel-heading">
	    <h3 class="panel-title">Trial Data <span class="description"><?php echo $description ?></span></h3>
	  </div>

	  <div class="dataTable handsontable"></div>

	</div>

</div>



<script src="<?php echo WEB_ROOT . "/module/heat_data/dist/script.min.js"; ?>"></script>
<!-- <script src="js/dist/m-heatData-trial.min.js"></script> -->

<script>
	m_heat_data.create( <?php echo "'" . $writeType . "'"; ?> );
	m_heat_data.populate( <?php echo "'" . $seq . "'"; ?> );
</script>




<?php
		// ... function continues
	}
?>