<?php
	$trialSeq = $_GET['trial-seq'];


	$servername = "localhost";
	$username = "trial_mgr_ro";
	$password = "manofsteel";
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
		$procChgNum = $row["proc_chg_num"];
		$TWINum = $row["twi_num"];
		$user = $row["user"];
		$unit = $row["unit"];
		$trialType = $row["trial_type"];
		$changeType = $row["change_type"];
		$bopVsl = $row["bop_vsl"];
		$degasVsl = $row["degas_vsl"];
		$argonNum = $row["argon_station"];
		$casterNum = $row["caster_num"];
		$strandNum = $row["strand_num"];
		$commentGoal = $row["comment_goal"];
		$commentMonitor = $row["comment_monitor"];
		$commentGeneral = $row["comment_general"];
		$commentConclusion = $row["comment_conclusion"];

	} else {
		$trialName = "Trial not found";
	}
?>

<div class="page-header">
  <h1><?php echo $trialName ?></h1>
</div>

<div class="container noPad-xs">

	<div id="m-trialInfo-view" class="panel panel-primary">
		<div class="panel-heading">
	    <h3 class="panel-title">Info<span class="description"></span>
	    </h3>
	  </div>


	  <div class="container form-inline noPad-xs">
			
			<div class="row noPad-xs" style="margin:0;">

		  	<div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="startDate input-group">
			    	<span class="elem-title">Start Date</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $startDate . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-6 fullPad-sm halfPad-xs">
				  <div class="endDate input-group">
			    	<span class="elem-title">End Date</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $endDate . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="processChange input-group">
			    	<span class="elem-title hidden-xs">Process Change</span>
				    	<span class="elem-title visible-xs">Proc Chg</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $procChgNum . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="twi input-group">
			    	<span class="elem-title">TWI</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $TWINum . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="owner input-group">
			    	<span class="elem-title">Owner</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $user . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="unit input-group">
			    	<span class="elem-title">Unit</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $unit . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="trialType input-group">
			    	<span class="elem-title">Trial Type</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $trialType . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			  <div class="col-sm-3 col-xs-4 fullPad-sm halfPad-xs">
				  <div class="changeType input-group">
			    	<span class="elem-title hidden-xs">Change Type</span>
				    <span class="elem-title visible-xs">Change</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $changeType . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

			</div>



			<div class="row noPad-xs" style="margin:0;">

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
					<div class="bopVsl input-group">
			    	<span class="elem-title hidden-xs">BOP Vsl</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">BOP Vsl</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $bopVsl . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="degasVsl input-group">
			    	<span class="elem-title hidden-xs">Degas Vsl</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">RH Vsl</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $degasVsl . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="argonNum input-group">
			    	<span class="elem-title hidden-xs">Argon #</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">Argon</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $argonNum . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="casterNum input-group">
			    	<span class="elem-title hidden-xs">Caster #</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">Caster</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $casterNum . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

				<div class="col15-sm-3 col15-xs-3 fullPad-sm halfPad-xs">
				  <div class="strandNum input-group">
			    	<span class="elem-title hidden-xs">Strand #</span>
			    	<span class="elem-title visible-xs" style="font-size:0.9em;">Strand</span>
			    	<input class="form-control" type="text" readonly value= <?php echo '"' . $strandNum . '"'; ?> >
			    	<span></span>
				  </div>
				</div>

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="goalText input-group">
            <span class="elem-title">Goals</span>
            <textarea class="form-control" readonly></textarea>
          </div>
        </div>

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="monitorText input-group">
            <span class="elem-title">Monitor</span>
            <textarea class="form-control" readonly></textarea>
          </div>
        </div>

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="otherInfoText input-group">
            <span class="elem-title">Other Info</span>
            <textarea class="form-control" readonly></textarea>
          </div>
        </div>

        <div class="col-sm-6 col-xs-12 fullPad-sm halfPad-xs">
          <div class="conclusionText input-group">
            <span class="elem-title">Conclusions</span>
            <textarea class="form-control" readonly></textarea>
          </div>
        </div>

			</div>

		</div>

	</div>


<!-- 
  <div class="row form-inline">

	  <div class="unit input-group">
    	<span class="elem-title">Unit</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $unit . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="trial-type input-group">
    	<span class="elem-title">Trial Type</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $trialType . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="change-type input-group">
    	<span class="elem-title">Change Type</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $changeType . '"'; ?> >
    	<span></span>
	  </div>

	</div>


	<div class="row form-inline">

	  <div class="bop-vsl input-group">
    	<span class="elem-title">BOP Vsl</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $bopVsl . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="degas-vsl input-group">
    	<span class="elem-title">Degas Vsl</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $degasVsl . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="argon-num input-group">
    	<span class="elem-title">Argon #</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $argonNum . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="caster-num input-group">
    	<span class="elem-title">Caster #</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $casterNum . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="strand-num input-group">
    	<span class="elem-title">Strand #</span>
    	<input class="form-control" type="text" readonly value= <?php echo '"' . $strandNum . '"'; ?> >
    	<span></span>
	  </div>

	</div>


	<div class="row form-inline">

		<div class="trial-goal form-group">
		  <span class="elem-title">Desired Results</span>
		  <textarea class="form-control" readonly><?php echo $commentGoal; ?></textarea>
		</div>

		<div class="trial-monitor form-group align-top">
		  <span class="elem-title">Aspects to Monitor</span>
		  <textarea class="form-control" readonly><?php echo $commentMonitor; ?></textarea>
		</div>

	</div>



	<div class="row form-inline">

		<div class="trial-comment form-group">
		  <span class="elem-title">General Comments</span>
		  <textarea class="form-control" readonly><?php echo $commentGeneral; ?></textarea>
		</div>

		<div class="trial-conclusion form-group">
		  <span class="elem-title">Conclusions (After Trial Completion)</span>
		  <textarea class="form-control" readonly><?php echo $commentConclusion; ?></textarea>
		</div>

	</div>
 -->

</div>












