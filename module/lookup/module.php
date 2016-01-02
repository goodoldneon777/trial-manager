<?php

	function create_lookup($pageType) {
		include(SERVER_ROOT . '/module/lookup/dist/c_createInput.php');


		if ($pageType === 'trial') {
			$module_class = "\"m_lookup panel panel-primary\"";
			$module_title = "Search Trials";
			$html_submitBtn = '<button type="button" class="submit btn btn-xlarge btn-success">Search Trials</button>';
		} else if ($pageType === 'group') {
			$module_class = "\"m_lookup panel panel-info\"";
			$module_title = "Search Groups";
			$html_submitBtn = '<button type="button" class="submit btn btn-xlarge btn-success">Search Groups</button>';
		}


		$html_name = create_input('name');
		$html_startDate = create_input('start_dt');
		$html_endDate = create_input('end_dt');
		$html_unit = create_input('unit');
		$html_goalType = create_input('goal_type');
		$html_changeType = create_input('change_type');

		//Function continues...
?>


<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/lookup/dist/style.css"; ?>">


<div class= <?php echo $module_class; ?> >

	<div class="panel-heading">
    <h3 class="panel-title">
    	<?php echo $module_title; ?>
    	<span class="description"></span>
    </h3>
  </div>



  <div class="container noPad-xs">

		<div class="row form-inline halfPad-xs">

			<div class="c_typeSelect col-xs-4 halfPad-xs">
			  <div class="input-group" style="vertial-align:middle;">
			  	<select class="form-control">
			  		<option>Lookup by Heats</option>
			  		<!-- <option>Search by Slabs</option> -->
				  </select>
				</div>
			</div>


			<div class="c_submitBtn col-xs-8 noPad-xs">
				<?php echo $html_submitBtn; ?>
			</div>

		</div>



		<div class="row form-inline">
			<div class="col-xs-2"></div>	<!--Blank columns used as spacers.-->

			<div class="c_errorBox col-xs-8 noPad-xs">
				<div class="content"></div>
			</div>

			<div class="col-xs-2"></div>	<!--Blank columns used as spacers.-->
		</div>



		<div class="row form-inline halfPad-xs">
			<div class="c_inputTable col-xs-4 halfPad-xs">
				<div class="inputTable handsontable"></div>
			</div>

			<div class="c_results col-xs-8 halfPad-xs">
				
			</div>
		</div>


	</div>

</div>






<script src="<?php echo WEB_ROOT . "/module/lookup/dist/script.min.js"; ?>"></script>




<?php

	}

?>
