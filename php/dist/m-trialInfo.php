<?php

	function create_trialInfo($type, $trialSeq = null) {

		// If there's a trial to display, query the trial info.
		if ($trialSeq !== null) {
			$servername = "localhost";
			$username = "trial_mgr_wr";
			$password = "womanofsteel";
			$dbname = "trial_mgr";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 


			$sql = "
				select 
					trial_name, start_dt, end_dt, proc_chg_num, twi_num, user,
					unit, trial_type, change_type, bop_vsl, degas_vsl, argon_station, 
					caster_num, strand_num, comment_goal, comment_monitor, 
					comment_general, comment_conclusion
				from trial
				where trial_seq = " . $trialSeq . " 
				";


			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();

				$trialName = $row["trial_name"];
				$startDate = date_format(date_create($row["start_dt"]), "n/j/Y G:i");
				$endDate = date_format(date_create($row["end_dt"]), "n/j/Y G:i");
				$processChange = $row["proc_chg_num"];
				$twi = $row["twi_num"];
				$owner = $row["user"];
				$unit = $row["unit"];
				$trialType = $row["trial_type"];
				$changeType = $row["change_type"];
				$bopVsl = $row["bop_vsl"];
				$degasVsl = $row["degas_vsl"];
				$argonNum = $row["argon_station"];
				$casterNum = $row["caster_num"];
				$strandNum = $row["strand_num"];
				$goalText = $row["comment_goal"];
				$monitorText = $row["comment_monitor"];
				$otherInfoText = $row["comment_general"];
				$conclusionText = $row["comment_conclusion"];

			} else {
				$trialName = "Trial not found";
			}
		}



		if ($type === 'readonly') {

			$html_header =
				'<div class="page-header">' . 
					'<h1>' . $trialName . '</h1>' .
				'</div>';

			$html_trialName =
				'';

			$html_startDate = 
				'<span class="elem-title">Start Date</span>' .
	    	'<input class="form-control" type="text" readonly value="' . $startDate . '">' .
	    	'<span></span>';

	    $html_endDate = 
				'<span class="elem-title">End Date</span>' .
	    	'<input class="form-control" type="text" readonly value="' . $endDate . '">' .
	    	'<span></span>';

			$html_unit = 
				'<span class="elem-title">Unit</span>' .
		    '<input class="form-control" type="text" readonly value="' . $unit . '">' .
		    '<span></span>';

		  $html_owner =
		  	'<span class="elem-title">Owner</span>' .
			  '<input class="form-control" type="text" readonly value="' . $owner . '">' .
			  '<span></span>';

	    $html_processChange =
	    	'<span class="elem-title hidden-xs">Process Change</span>' .
		    '<span class="elem-title visible-xs">Proc Chg</span>' .
	    	'<input class="form-control" type="text" readonly value="' . $processChange . '">' .
	    	'<span></span>';

	    $html_twi =
	    	'<span class="elem-title">TWI</span>' .
			  '<input class="form-control" type="text" readonly value="' . $twi . '">' .
			  '<span></span>';

		  $html_trialType =
		  	'<span class="elem-title">Trial Type</span>' .
		    '<input class="form-control" type="text" readonly value="' . $trialType . '">' .
		    '<span></span>';

		  $html_changeType =
		  	'<span class="elem-title hidden-xs">Change Type</span>' .
				'<span class="elem-title visible-xs">Change</span>' .
		   	'<input class="form-control" type="text" readonly value="' . $changeType . '">' .
		    '<span></span>';

			$html_bopVsl =
				'<span class="elem-title hidden-xs">BOP Vsl</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">BOP Vsl</span>' .
    		'<input class="form-control" type="text" readonly value="' . $bopVsl . '">' .
    		'<span></span>';

    	$html_degasVsl =
    		'<span class="elem-title hidden-xs">Degas Vsl</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">RH Vsl</span>' .
    		'<input class="form-control" type="text" readonly value="' . $degasVsl . '">' .
    		'<span></span>';

    	$html_argonNum =
    		'<span class="elem-title hidden-xs">Argon #</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">Argon</span>' .
    		'<input class="form-control" type="text" readonly value="' . $argonNum . '">' .
    		'<span></span>';

    	$html_casterNum =
    		'<span class="elem-title hidden-xs">Caster #</span>' .
			  '<span class="elem-title visible-xs" style="font-size:0.9em;">Caster</span>' .
		    '<input class="form-control" type="text" readonly value="' . $casterNum . '">' .
		    '<span></span>';

		  $html_strandNum =
		  	'<span class="elem-title hidden-xs">Strand #</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">Strand</span>' .
    		'<input class="form-control" type="text" readonly value="' . $strandNum . '">' .
    		'<span></span>';

    	$html_goalText =
    		'<span class="elem-title">Goals</span>' .
        '<textarea class="form-control" readonly>' . $goalText . '</textarea>' .
        '<span></span>';

    	$html_monitorText =
    		'<span class="elem-title">Monitor</span>' .
        '<textarea class="form-control" readonly>' . $monitorText . '</textarea>' .
        '<span></span>';

    	$html_otherInfoText =
    		'<span class="elem-title">Other Info</span>' .
        '<textarea class="form-control" readonly>' . $otherInfoText . '</textarea>' .
        '<span></span>';

    	$html_conclusionText =
    		'<span class="elem-title">Conclusion</span>' .
        '<textarea class="form-control" readonly>' . $conclusionText . '</textarea>' .
        '<span></span>';
    } else if ($type === 'write') {

			$html_header =
				'';

			$html_trialName =
				'<div class="col-sm-2 fullPad-sm halfPad-xs"></div>' .
				'<div class="col-sm-8 fullPad-sm halfPad-xs">' .
				'  <div class="trialName input-group">' .
				'    <span class="elem-title required">Trial Name</span>' .
    		'    <input class="form-control" type="text" data-toggle="tooltip" title="Can be the same as a previous trial name." value="' . $trialName . '">' .
    		'    <span></span>' .
    		'  </div>' .
    		'</div>' . 
    		'<div class="col-sm-2 fullPad-sm halfPad-xs"></div>';

			$html_startDate = 
				'<span class="elem-title required">Start Date</span>' .
	    	'<input class="form-control" type="text" value="' . $startDate . '">' .
	    	'<span></span>';

	    $html_endDate = 
				'<span class="elem-title required">End Date</span>' .
	    	'<input class="form-control" type="text" value="' . $endDate . '">' .
	    	'<span></span>';

			$html_unit = 
				'<span class="elem-title required">Unit</span>' .
			  '<select class="form-control" data-toggle="tooltip" title="Area where this trial will be performed." text="BOP">' .
			  '  <option></option>' .
			  '  <option' . ( ($unit === 'BF') ? " selected" : "" ) . '>BF</option>' .
	 			'  <option' . ( ($unit === 'BOP') ? " selected" : "" ) . '>BOP</option>' .
				'  <option' . ( ($unit === 'Degas') ? " selected" : "" ) . '>Degas</option>' .
				'  <option' . ( ($unit === 'Argon') ? " selected" : "" ) . '>Argon</option>' .
				'  <option' . ( ($unit === 'LMF') ? " selected" : "" ) . '>LMF</option>' .
				'  <option' . ( ($unit === 'Caster') ? " selected" : "" ) . '>Caster</option>' .
				'  <option' . ( ($unit === 'Other') ? " selected" : "" ) . '>Other</option>' . 
			  '</select>';

		  $html_owner =
		  	'<span class="elem-title required">Owner</span>' .
			  '<input class="form-control" type="text" value="' . $owner . '">' .
			  '<span></span>';

	    $html_processChange =
	    	'<span class="elem-title hidden-xs">Process Change</span>' .
		    '<span class="elem-title visible-xs">Proc Chg</span>' .
	    	'<input class="form-control" type="text" value="' . $processChange . '">' .
	    	'<span></span>';

	    $html_twi =
	    	'<span class="elem-title">TWI</span>' .
			  '<input class="form-control" type="text" value="' . $twi . '">' .
			  '<span></span>';

		  $html_trialType =
		  	'<span class="elem-title">Trial Type</span>' .
		  	'<select class="form-control" data-toggle="tooltip" title="In general, what is this trial trying to improve?">' .
		    '  <option></option>' .
		    '  <option' . ( ($trialType === 'Cost') ? " selected" : "" ) . '>Cost</option>' .
		    '  <option' . ( ($trialType === 'Process') ? " selected" : "" ) . '>Process</option>' .
		    '  <option' . ( ($trialType === 'Quality') ? " selected" : "" ) . '>Quality</option>' .
		    '  <option' . ( ($trialType === 'Safety') ? " selected" : "" ) . '>Safety</option>' .
		    '  <option' . ( ($trialType === 'Other') ? " selected" : "" ) . '>Other</option>' .
		  	'</select>';

		  $html_changeType =
		  	'<span class="elem-title">Change Type</span>' .
		  	'<select class="form-control" data-toggle="tooltip" title="In general, what is this trial changing?">' .
		    '  <option></option>' .
		    '  <option' . ( ($changeType === 'Equipment') ? " selected" : "" ) . '>Equipment</option>' .
		    '  <option' . ( ($changeType === 'Material') ? " selected" : "" ) . '>Material</option>' .
		    '  <option' . ( ($changeType === 'Model') ? " selected" : "" ) . '>Model</option>' .
		    '  <option' . ( ($changeType === 'Procedure') ? " selected" : "" ) . '>Procedure</option>' .
		    '  <option' . ( ($changeType === 'Other') ? " selected" : "" ) . '>Other</option>' .
		  	'</select>';

			$html_bopVsl =
				'<span class="elem-title hidden-xs">BOP Vsl</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">BOP Vsl</span>' .
    		'<select class="form-control" data-toggle="tooltip" title="Does this trial affect only one BOP vessel?">' .
		    '  <option></option>' .
		    '  <option' . ( ($bopVsl === '25') ? " selected" : "" ) . '>25</option>' .
		    '  <option' . ( ($bopVsl === '26') ? " selected" : "" ) . '>26</option>' .
		  	'</select>';

    	$html_degasVsl =
    		'<span class="elem-title hidden-xs">Degas Vsl</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">RH Vsl</span>' .
    		'<select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Degasser vessel?">' .
		    '  <option></option>' .
		    '  <option' . ( ($degasVsl === '1') ? " selected" : "" ) . '>1</option>' .
		    '  <option' . ( ($degasVsl === '2') ? " selected" : "" ) . '>2</option>' .
		  	'</select>';

    	$html_argonNum =
    		'<span class="elem-title hidden-xs">Argon #</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">Argon</span>' .
    		'<select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Argon station?">' .
		    '  <option></option>' .
		    '  <option' . ( ($argonNum === '1') ? " selected" : "" ) . '>1</option>' .
		    '  <option' . ( ($argonNum === '2') ? " selected" : "" ) . '>2</option>' .
		  	'</select>';

    	$html_casterNum =
    		'<span class="elem-title hidden-xs">Caster #</span>' .
			  '<span class="elem-title visible-xs" style="font-size:0.9em;">Caster</span>' .
		    '<select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster?">' .
		    '  <option></option>' .
		    '  <option' . ( ($casterNum === '1') ? " selected" : "" ) . '>1</option>' .
		    '  <option' . ( ($casterNum === '2') ? " selected" : "" ) . '>2</option>' .
		  	'</select>';

		  $html_strandNum =
		  	'<span class="elem-title hidden-xs">Strand #</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">Strand</span>' .
    		'<select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster strand?">' .
		    '  <option></option>' .
		    '  <option' . ( ($strandNum === '1') ? " selected" : "" ) . '>1</option>' .
		    '  <option' . ( ($strandNum === '2') ? " selected" : "" ) . '>2</option>' .
		    '  <option' . ( ($strandNum === '3') ? " selected" : "" ) . '>3</option>' .
		    '  <option' . ( ($strandNum === '4') ? " selected" : "" ) . '>4</option>' .
		  	'</select>';

    	$html_goalText =
    		'<span class="elem-title">Goals</span>' .
        '<textarea class="form-control">' . $goalText . '</textarea>' .
        '<span></span>';

    	$html_monitorText =
    		'<span class="elem-title">Monitor</span>' .
        '<textarea class="form-control">' . $monitorText . '</textarea>' .
        '<span></span>';

    	$html_otherInfoText =
    		'<span class="elem-title">Other Info</span>' .
        '<textarea class="form-control">' . $otherInfoText . '</textarea>' .
        '<span></span>';

    	$html_conclusionText =
    		'<span class="elem-title">Conclusion</span>' .
        '<textarea class="form-control">' . $conclusionText . '</textarea>' .
        '<span></span>';
    }

?>






<?php echo $html_header; ?>


<div class="container noPad-xs">

	<div id="m-trialInfo" class="panel panel-primary">
		<div class="panel-heading">
	    <h3 class="panel-title">Info<span class="description"></span>
	    </h3>
	  </div>


	  <div class="container form-inline noPad-xs">

			<div class="row noPad-xs" style="margin:0;">

				<?php echo $html_trialName; ?>



		  	<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="startDate input-group">
			    	<?php echo $html_startDate; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="endDate input-group">
			    	<?php echo $html_endDate; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="unit input-group">
			    	<?php echo $html_unit; ?>
					</div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="owner input-group">
			    	<?php echo $html_owner; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="processChange input-group">
			    	<?php echo $html_processChange; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="twi input-group">
			    	<?php echo $html_twi; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="trialType input-group">
			    	<?php echo $html_trialType; ?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="changeType input-group">
			    	<?php echo $html_changeType; ?>
				  </div>
				</div>

			</div>


			<!-- Horizontal break line -->
			<div class="col-xs-12"><hr></div>



			<div class="row noPad-xs" style="margin:0;">

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
					<div class="bopVsl input-group">
			    	<?php echo $html_bopVsl; ?>
				  </div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="degasVsl input-group">
			    	<?php echo $html_degasVsl; ?>
				  </div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="argonNum input-group">
			    	<?php echo $html_argonNum; ?>
					</div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="casterNum input-group">
			    	<?php echo $html_casterNum; ?>
					</div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="strandNum input-group">
			    	<?php echo $html_strandNum; ?>
				  </div>
				</div>

			</div>

				<!-- Horizontal break line -->
				<div class="col-xs-12"><hr></div>

			<div class="row noPad-xs" style="margin:0;">

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="goalText input-group">
            <?php echo $html_goalText; ?>
          </div>
        </div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="monitorText input-group">
            <?php echo $html_monitorText; ?>
          </div>
        </div>

      </div>



      <div class="row noPad-xs" style="margin:0;">

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="otherInfoText input-group">
            <?php echo $html_otherInfoText; ?>
          </div>
        </div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="conclusionText input-group">
            <?php echo $html_conclusionText; ?>
          </div>
        </div>

			</div>

		</div>

	</div>


</div>


<script src="js/dist/m-trialInfo.min.js"></script>



<?php


		// $html = ob_get_contents();

		// return $html;

		// ob_end_clean();
	}


	

?>






