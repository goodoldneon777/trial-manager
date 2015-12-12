<?php

	function create_groupInfo($type, $groupSeq = null) {
		$server = getenv('server');
		$userWR = getenv('userWR');
		$passWR = getenv('passWR');
		$db = getenv('db');

		// If there's a trial to display, query the trial info.
		if ($groupSeq !== null) {
			// Create connection
			$conn = new mysqli($server, $userWR, $passWR, $db);
			// Check connection
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			} 


			$sql = "
				select 
					name, start_dt, end_dt, owner, unit, goal_type, change_type, 
					bop_vsl, degas_vsl, argon_station, caster_num, strand_num, 
					comment_goal, comment_monitor, comment_general, comment_conclusion
				from trial_group
				where group_seq = " . $groupSeq . " 
				";

			$result = $conn->query($sql);


			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();

				$name = $row["name"];
				$startDate = date_format(date_create($row["start_dt"]), "n/j/Y G:i");
				$endDate = date_format(date_create($row["end_dt"]), "n/j/Y G:i");
				$owner = $row["owner"];
				$unit = $row["unit"];
				$goalType = $row["goal_type"];
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
				$name = "Group not found";
			}
		} else {
			$name = "";
			$startDate = "";
			$endDate = "";
			$owner = "";
			$unit = "";
			$goalType = "";
			$changeType = "";
			$bopVsl = "";
			$degasVsl = "";
			$argonNum = "";
			$casterNum = "";
			$strandNum = "";
			$goalText = "";
			$monitorText = "";
			$otherInfoText = "";
			$conclusionText = "";
		}



		if ($type === 'readonly') {

			$html_header =
				'<div class="page-header">' . 
					'<h1>' . $name . '</h1>' .
				'</div>';

			$html_name =
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

		  $html_goalType =
		  	'<span class="elem-title">Goal Type</span>' .
		    '<input class="form-control" type="text" readonly value="' . $goalType . '">' .
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
				'<div class="page-header">' . 
					'<h1>' . $name . '</h1>' .
				'</div>';

			$html_name =
				'<div class="col-sm-2 fullPad-sm halfPad-xs"></div>' .
				'<div class="col-sm-8 fullPad-sm halfPad-xs">' .
				'  <div class="name input-group">' .
				'    <span class="elem-title required">Group Name</span>' .
    		'    <input class="form-control" type="text" data-toggle="tooltip" title="Can be the same as a previous group name." value="' . $name . '">' .
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
			  '<select class="form-control" data-toggle="tooltip" title="Area where this group of trials will be performed." text="BOP">' .
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

		  $html_goalType =
		  	'<span class="elem-title">Goal Type</span>' .
		  	'<select class="form-control" data-toggle="tooltip" title="In general, what is this group of trials trying to improve?">' .
		    '  <option></option>' .
		    '  <option' . ( ($goalType === 'Cost') ? " selected" : "" ) . '>Cost</option>' .
		    '  <option' . ( ($goalType === 'Process') ? " selected" : "" ) . '>Process</option>' .
		    '  <option' . ( ($goalType === 'Quality') ? " selected" : "" ) . '>Quality</option>' .
		    '  <option' . ( ($goalType === 'Safety') ? " selected" : "" ) . '>Safety</option>' .
		    '  <option' . ( ($goalType === 'Other') ? " selected" : "" ) . '>Other</option>' .
		  	'</select>';

		  $html_changeType =
		  	'<span class="elem-title">Change Type</span>' .
		  	'<select class="form-control" data-toggle="tooltip" title="In general, what is this group of trials changing?">' .
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
    		'<select class="form-control" data-toggle="tooltip" title="Does this group of trials affect only one BOP vessel?">' .
		    '  <option></option>' .
		    '  <option' . ( ($bopVsl === '25') ? " selected" : "" ) . '>25</option>' .
		    '  <option' . ( ($bopVsl === '26') ? " selected" : "" ) . '>26</option>' .
		  	'</select>';

    	$html_degasVsl =
    		'<span class="elem-title hidden-xs">Degas Vsl</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">RH Vsl</span>' .
    		'<select class="form-control" data-toggle="tooltip" title="Does this group of trials affect only one Degasser vessel?">' .
		    '  <option></option>' .
		    '  <option' . ( ($degasVsl === '1') ? " selected" : "" ) . '>1</option>' .
		    '  <option' . ( ($degasVsl === '2') ? " selected" : "" ) . '>2</option>' .
		  	'</select>';

    	$html_argonNum =
    		'<span class="elem-title hidden-xs">Argon #</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">Argon</span>' .
    		'<select class="form-control" data-toggle="tooltip" title="Does this group of trials affect only one Argon station?">' .
		    '  <option></option>' .
		    '  <option' . ( ($argonNum === '1') ? " selected" : "" ) . '>1</option>' .
		    '  <option' . ( ($argonNum === '2') ? " selected" : "" ) . '>2</option>' .
		  	'</select>';

    	$html_casterNum =
    		'<span class="elem-title hidden-xs">Caster #</span>' .
			  '<span class="elem-title visible-xs" style="font-size:0.9em;">Caster</span>' .
		    '<select class="form-control" data-toggle="tooltip" title="Does this group of trials affect only one Caster?">' .
		    '  <option></option>' .
		    '  <option' . ( ($casterNum === '1') ? " selected" : "" ) . '>1</option>' .
		    '  <option' . ( ($casterNum === '2') ? " selected" : "" ) . '>2</option>' .
		  	'</select>';

		  $html_strandNum =
		  	'<span class="elem-title hidden-xs">Strand #</span>' .
	    	'<span class="elem-title visible-xs" style="font-size:0.9em;">Strand</span>' .
    		'<select class="form-control" data-toggle="tooltip" title="Does this group of trials affect only one Caster strand?">' .
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

	<div class="m-groupInfo panel panel-info">
		<div class="panel-heading">
	    <h3 class="panel-title">Group Info<span class="description"></span>
	    </h3>
	  </div>


	  <div class="container form-inline noPad-xs">

			<div class="row noPad-xs" style="margin:0;">

				<?php echo $html_name; ?>



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
				  <div class="goalType input-group">
			    	<?php echo $html_goalType; ?>
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


<script src="js/dist/m-groupInfo.min.js"></script>



<?php


	}


	

?>






