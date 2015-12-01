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

		ob_start();
?>

<?php
	if ($type === 'readonly') {
?>
<div class="page-header">
  <h1><?php echo $trialName; ?></h1>
</div>
<?php
	}
?>

<div class="container noPad-xs">

	<div id="m-trialInfo" class="panel panel-primary">
		<div class="panel-heading">
	    <h3 class="panel-title">Info<span class="description"></span>
	    </h3>
	  </div>


	  <div class="container form-inline noPad-xs">
			
<?php
	if ($type === 'write') {
?>
			<div class="row noPad-xs" style="margin:0; width:100%;">

				<!-- Dummy column to center the trial name -->
				<div class="col-sm-2 hidden-xs"></div>

		  	<div class="col-sm-8 col-xs-12 fullPad-sm halfPad-xs" style="margin:auto;">
				  <div class="trialName input-group">
			    	<span class="elem-title">Trial Name</span>
			    	<input class="form-control" type="text" data-toggle="tooltip" title="Can be the same as a previous trial name." value=<?php echo '"' . $trialName . '"'; ?>>
			    	<span></span>
				  </div>
				</div>

				<!-- Dummy column to center the trial name -->
				<div class="col-sm-2 hidden-xs"></div>

			</div>
<?php
	}
?>


			<div class="row noPad-xs" style="margin:0;">

		  	<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="startDate input-group">
			    	<span class="elem-title">Start Date</span>
			    	<input class="form-control" type="text"
			    		<?php if ($type === 'readonly') { echo "readonly"; } ?>
			    		<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"Date this trial started. You may optionally put the time.\""; } ?>
			    		value=<?php echo '"' . $startDate . '"'; ?>>
			    	<span></span>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="endDate input-group">
			    	<span class="elem-title">End Date</span>
			    	<input class="form-control" type="text"
			    		<?php if ($type === 'readonly') { echo "readonly"; } ?>
			    		<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"Date this trial ended. You may optionally put the time.\""; } ?>
			    		value=<?php echo '"' . $endDate . '"'; ?>>
			    	<span></span>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="processChange input-group">
			    	<span class="elem-title hidden-xs">Process Change</span>
				    	<span class="elem-title visible-xs">Proc Chg</span>
			    	<input class="form-control" type="text"
			    		<?php if ($type === 'readonly') { echo "readonly"; } ?>
			    		<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"Process change number.\""; } ?>
			    		value=<?php echo '"' . $processChange . '"'; ?>>
			    	<span></span>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="twi input-group">
			    	<span class="elem-title">TWI</span>
			    	<input class="form-control" type="text"
			    		<?php if ($type === 'readonly') { echo "readonly"; } ?>
			    		<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"Temporary work instruction (TWI) number.\""; } ?>
			    		value=<?php echo '"' . $twi . '"'; ?>>
			    	<span></span>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="unit input-group">
			    	<span class="elem-title">Unit</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" <?php if ($type === 'readonly') { echo "readonly"; } ?> value=<?php echo '"' . $unit . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
						  <select class="form-control" data-toggle="tooltip" title="Area where this trial will be performed.">
						    <option></option>
						    <option <?php if ($unit === 'BF') { echo "selected"; } ?>>BF</option>
						    <option <?php if ($unit === 'BOP') { echo "selected"; } ?>>BOP</option>
						    <option <?php if ($unit === 'Degas') { echo "selected"; } ?>>Degas</option>
						    <option <?php if ($unit === 'Argon') { echo "selected"; } ?>>Argon</option>
						    <option <?php if ($unit === 'LMF') { echo "selected"; } ?>>LMF</option>
						    <option <?php if ($unit === 'Caster') { echo "selected"; } ?>>Caster</option>
						    <option <?php if ($unit === 'Other') { echo "selected"; } ?>>Other</option>
						  </select>
<?php
	}
?>
					</div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="trialType input-group">
			    	<span class="elem-title">Trial Type</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" <?php if ($type === 'readonly') { echo "readonly"; } ?> value=<?php echo '"' . $trialType . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
						  <select class="form-control" data-toggle="tooltip" title="In general, what is this trial trying to improve?">
						    <option></option>
						    <option <?php if ($trialType === 'Cost') { echo "selected"; } ?>>Cost</option>
						    <option <?php if ($trialType === 'Process') { echo "selected"; } ?>>Process</option>
						    <option <?php if ($trialType === 'Quality') { echo "selected"; } ?>>Quality</option>
						    <option <?php if ($trialType === 'Safety') { echo "selected"; } ?>>Safety</option>
						    <option <?php if ($trialType === 'Other') { echo "selected"; } ?>>Other</option>
						  </select>
<?php
	}
?>
				  </div>
				</div>



			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="changeType input-group">
			    	<span class="elem-title hidden-xs">Change Type</span>
				    <span class="elem-title visible-xs">Change</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" <?php if ($type === 'readonly') { echo "readonly"; } ?> value=<?php echo '"' . $changeType . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
						  <select class="form-control" data-toggle="tooltip" title="In general, what is this trial trying to improve?">
						    <option></option>
						    <option <?php if ($changeType === 'Equipment') { echo "selected"; } ?>>Equipment</option>
						    <option <?php if ($changeType === 'Material') { echo "selected"; } ?>>Material</option>
						    <option <?php if ($changeType === 'Model') { echo "selected"; } ?>>Model</option>
						    <option <?php if ($changeType === 'Procedure') { echo "selected"; } ?>>Procedure</option>
						    <option <?php if ($changeType === 'Other') { echo "selected"; } ?>>Other</option>
						  </select>
<?php
	}
?>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="owner input-group">
			    	<span class="elem-title">Owner</span>
			    	<input class="form-control" type="text"
			    		<?php if ($type === 'readonly') { echo "readonly"; } ?>
			    		<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"Person in charge of this trial. Usually the person who will be analyzing the data.\""; } ?>
			    		value=<?php echo '"' . $owner . '"'; ?>>
			    	<span></span>
				  </div>
				</div>

			</div>



			<div class="row noPad-xs" style="margin:0;">

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
					<div class="bopVsl input-group">
			    	<span class="elem-title hidden-xs">BOP Vsl</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">BOP Vsl</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" readonly value=<?php echo '"' . $bopVsl . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
					  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one BOP vessel?">
					    <option></option>
					    <option <?php if ($bopVsl === '25') { echo "selected"; } ?>>25</option>
					    <option <?php if ($bopVsl === '26') { echo "selected"; } ?>>26</option>
					  </select>
<?php
	}
?>
				  </div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="degasVsl input-group">
			    	<span class="elem-title hidden-xs">Degas Vsl</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">RH Vsl</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" readonly value=<?php echo '"' . $degasVsl . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
					  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Degasser vessel?">
					    <option></option>
					    <option <?php if ($degasVsl === '1') { echo "selected"; } ?>>1</option>
					    <option <?php if ($degasVsl === '2') { echo "selected"; } ?>>2</option>
					  </select>
<?php
	}
?>
				  </div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="argonNum input-group">
			    	<span class="elem-title hidden-xs">Argon #</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">Argon</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" readonly value=<?php echo '"' . $argonNum . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
					  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Argon station?">
					    <option></option>
					    <option <?php if ($argonNum === '1') { echo "selected"; } ?>>1</option>
					    <option <?php if ($argonNum === '2') { echo "selected"; } ?>>2</option>
					  </select>
<?php
	}
?>
					</div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="casterNum input-group">
			    	<span class="elem-title hidden-xs">Caster #</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">Caster</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" readonly value=<?php echo '"' . $casterNum . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
					  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster?">
					    <option></option>
					    <option <?php if ($casterNum === '1') { echo "selected"; } ?>>1</option>
					    <option <?php if ($casterNum === '2') { echo "selected"; } ?>>2</option>
					  </select>
<?php
	}
?>
					</div>
				</div>



				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="strandNum input-group">
			    	<span class="elem-title hidden-xs">Strand #</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">Strand</span>
<?php
	if ($type === 'readonly') {
?>
			    		<input class="form-control" type="text" readonly value=<?php echo '"' . $strandNum . '"'; ?>>
			    		<span></span>
<?php
	} else if ($type === 'write') {
?>
					  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster strand?">
					    <option></option>
					    <option <?php if ($strandNum === '1') { echo "selected"; } ?>>1</option>
					    <option <?php if ($strandNum === '2') { echo "selected"; } ?>>2</option>
					    <option <?php if ($strandNum === '3') { echo "selected"; } ?>>3</option>
					    <option <?php if ($strandNum === '4') { echo "selected"; } ?>>4</option>
					  </select>
<?php
	}
?>
				  </div>
				</div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="goalText input-group">
            <span class="elem-title">Goals</span>
            <textarea class="form-control"
            	<?php if ($type === 'readonly') { echo "readonly"; } ?>
            	<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"What is this trial to improve?\""; } ?>><?php echo $goalText; ?></textarea>
            <span></span>
          </div>
        </div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="monitorText input-group">
            <span class="elem-title">Monitor</span>
            <textarea class="form-control"
            	<?php if ($type === 'readonly') { echo "readonly"; } ?>
            	<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"What must be monitored?\""; } ?>><?php echo $monitorText; ?></textarea>
            <span></span>
          </div>
        </div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="otherInfoText input-group">
            <span class="elem-title">Other Info</span>
            <textarea class="form-control"
            	<?php if ($type === 'readonly') { echo "readonly"; } ?>
            	<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"Any miscellaneous info about this trial.\""; } ?>><?php echo $otherInfoText; ?></textarea>
            <span></span>
          </div>
        </div>



        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="conclusionText input-group">
            <span class="elem-title">Conclusions</span>
            <textarea class="form-control"
            	<?php if ($type === 'readonly') { echo "readonly"; } ?>
            	<?php if ($type === 'write') { echo "data-toggle=\"tooltip\" title=\"What were the results of the trial? Was it successful? Should another trial be performed?\""; } ?>><?php echo $conclusionText; ?></textarea>
            <span></span>
          </div>
        </div>

			</div>

		</div>

	</div>


</div>




<?php
		$html = ob_get_contents();

		return $html;

		ob_end_clean();
	}


	

?>






