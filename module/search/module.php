<?php

	function create_search($pageType) {
		if ($pageType === 'trial') {
			$module_class = "\"m_search panel panel-primary\"";
			$module_title = "Search Trials";
			$html_submitBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success">Search Trials</button>';
		} else if ($pageType === 'group') {
			$module_class = "\"m_search panel panel-info\"";
			$module_title = "Search Groups";
			$html_submitBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success">Search Groups</button>';
		}
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
			    	<span class="elem-title">Name</span>
			    	<input class="form-control" type="text" data-toggle="tooltip" title="Partial name search. For example, 'BOP FeP Addition' would show up if you enter 'FeP'.">
			    	<span></span>
				  </div>
				</div>

				<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="start-date input-group">
			    	<span class="elem-title">Start Date</span>
			    	<input class="form-control" type="text" data-toggle="tooltip" title="Anything that occurred on or after this date.">
			    	<span></span>
				  </div>
				</div>

				<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="end-date input-group">
			    	<span class="elem-title">End Date</span>
			    	<input class="form-control" type="text" data-toggle="tooltip" title="Anything that occurred on or before this date.">
			    	<span></span>
				  </div>
				</div>

			</div>


			<br>


			<div class="row form-inline">

				<div class="col-sm-4 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="unit input-group">
					  <span class="elem-title">Unit</span>
					  <select class="form-control">
					    <option></option>
					    <option>BF</option>
					    <option>BOP</option>
					    <option>Degas</option>
					    <option>Argon</option>
					    <option>LMF</option>
					    <option>Caster</option>
					    <option>Other</option>
					  </select>
					</div>
				</div>

				<div class="col-sm-4 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="goal-type input-group">
					  <span class="elem-title">Goal Type</span>
					  <select class="form-control">
					    <option></option>
					    <option>Cost</option>
					    <option>Process</option>
					    <option>Quality</option>
					    <option>Safety</option>
					    <option>Other</option>
					  </select>
					</div>
				</div>

				<div class="col-sm-4 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="change-type input-group">
					  <span class="elem-title">Change Type</span>
					  <select class="form-control">
					    <option></option>
					    <option>Equipment</option>
					    <option>Material</option>
					    <option>Model</option>
					    <option>Procedure</option>
					    <option>Other</option>
					  </select>
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
