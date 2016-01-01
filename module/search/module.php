<?php

	function create_search($pageType) {
		include(SERVER_ROOT . '/module/search/dist/c_createInput.php');


		if ($pageType === 'trial') {
			$module_class = "\"m_search panel panel-primary\"";
			$module_title = "Search Trials";
			$html_submitBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success">Search Trials</button>';
		} else if ($pageType === 'group') {
			$module_class = "\"m_search panel panel-info\"";
			$module_title = "Search Groups";
			$html_submitBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success">Search Groups</button>';
		}


		$html_name = create_input('name');
		$html_startDate = create_input('start_dt');
		$html_endDate = create_input('end_dt');
		$html_unit = create_input('unit');
		$html_goalType = create_input('goal_type');
		$html_changeType = create_input('change_type');

		//Function continues...
?>


<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/search/dist/style.css"; ?>">


<div class= <?php echo $module_class; ?> >

	<div class="panel-heading">
    <h3 class="panel-title">
    	<?php echo $module_title; ?>
    	<span class="description"></span>
    </h3>
  </div>


  <div class="container form-inline noPad-xs">

  	<div class="c_form">

			<div class="row noPad-xs">

				<div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
				  <div class="name input-group">
			    	<?php echo $html_name; ?>
				  </div>
				</div>

				<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="start-date input-group">
			    	<?php echo $html_startDate; ?>
				  </div>
				</div>

				<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="end-date input-group">
			    	<?php echo $html_endDate; ?>
				  </div>
				</div>

			</div>


			<br>


			<div class="row form-inline">

				<div class="col-sm-4 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="unit input-group">
					  <?php echo $html_unit; ?>
					</div>
				</div>

				<div class="col-sm-4 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="goal-type input-group">
					  <?php echo $html_goalType; ?>
					</div>
				</div>

				<div class="col-sm-4 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="change-type input-group">
					  <?php echo $html_changeType; ?>
					</div>
				</div>

			</div>

		</div>



		<div class="container form-inline noPad-xs">
			<!-- Horizontal break line -->
			<div class="col-xs-12"><hr></div>



			<div class="c_submitBtn col-xs-12">
				<?php echo $html_submitBtn; ?>
			</div>
		</div>



		<div class="c_errorBox">
			<div class="content"></div>
		</div>



		<div class="container form-inline noPad-xs">
			<div class="c_results col-xs-12 noPad-xs"></div>
		</div>


	</div>

</div>












<script src="<?php echo WEB_ROOT . "/module/search/dist/script.min.js"; ?>"></script>




<?php

	}

?>
