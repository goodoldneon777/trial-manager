<?php
	$trialSeq = $_GET['trial-seq'];


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

<div id="m-trialInfo-write" class="panel panel-primary">
	<div class="panel-heading">
    <h3 class="panel-title">Trial Info<span class="description"></span>
    </h3>
  </div>


  <div class="row form-inline">

	  <div class="trial-name input-group">
    	<span class="elem-title required">Trial Name</span>
    	<input class="form-control" type="text" data-toggle="tooltip" title="Can be the same as a previous trial name. 'Start Date' will differentiate trials with the same name." value= <?php echo '"' . $trialName . '"'; ?> >
    	<span></span>
	  </div>
	  
	  <div class="user input-group">
    	<span class="elem-title required">User Name</span>
    	<input class="form-control" type="text" data-toggle="tooltip" title="User name for the person managing this trial." value= <?php echo '"' . $user . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="start-date input-group">
    	<span class="elem-title">Start Date</span>
    	<input class="form-control" type="text" data-toggle="tooltip" title="Date this trial started. You may optionally put the time." value= <?php echo '"' . $startDate . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="end-date input-group">
    	<span class="elem-title">End Date</span>
    	<input class="form-control" type="text" data-toggle="tooltip" title="Date this trial ended. You may optionally put the time." value= <?php echo '"' . $endDate . '"'; ?> >
    	<span></span>
	  </div>

	</div>



	<br>



	<div class="row form-inline">

	  <div class="proc-chg-num input-group">
    	<span class="elem-title">Process Change #</span>
    	<input class="form-control" type="text" placeholder="" data-toggle="tooltip" title="Process change number." value= <?php echo '"' . $procChgNum . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="twi-num input-group">
    	<span class="elem-title">TWI #</span>
    	<input class="form-control" type="text" placeholder="" data-toggle="tooltip" title="Temporary work instruction (TWI) number." value= <?php echo '"' . $TWINum . '"'; ?> >
    	<span></span>
	  </div>

	  <div class="trial-unit form-group">
		  <span class="elem-title">Unit</span>
		  <select class="form-control" data-toggle="tooltip" title="Area where this trial will be performed." text="BOP">
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

	  <div class="trial-type form-group">
		  <span class="elem-title">Trial Type</span>
		  <select class="form-control" data-toggle="tooltip" title="In general, what is this trial trying to improve?">
		    <option></option>
		    <option>Cost</option>
		    <option>Process</option>
		    <option>Quality</option>
		    <option>Safety</option>
		    <option>Other</option>
		  </select>
		</div>

	  <div class="change-type form-group">
		  <span class="elem-title">Change Type</span>
		  <select class="form-control" data-toggle="tooltip" title="In general, what is this trial changing?">
		    <option></option>
		    <option>Equipment</option>
		    <option>Material</option>
		    <option>Model</option>
		    <option>Procedure</option>
		    <option>Other</option>
		  </select>
		</div>

	</div>



	<div class="row form-inline">

	  <div class="bop-vsl unit-nums form-group">
		  <span class="elem-title">BOP Vsl</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one BOP vessel?">
		    <option></option>
		    <option>25</option>
		    <option>26</option>
		  </select>
		</div>

	  <div class="degas-vsl unit-nums form-group">
		  <span class="elem-title">Degas Vsl</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Degasser vessel?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		  </select>
		</div>

	  <div class="argon-num unit-nums form-group">
		  <span class="elem-title">Argon #</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Argon station?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		  </select>
		</div>

	  <div class="caster-num unit-nums form-group">
		  <span class="elem-title">Caster #</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		  </select>
		</div>

	  <div class="strand-num unit-nums form-group">
		  <span class="elem-title">Strand #</span>
		  <select class="form-control" data-toggle="tooltip" title="Does this trial affect only one Caster strand?">
		    <option></option>
		    <option>1</option>
		    <option>2</option>
		    <option>3</option>
		    <option>4</option>
		  </select>
		</div>

	</div>



	<br>



	<div class="row form-inline">

		<div class="trial-goal form-group">
		  <span class="elem-title">Desired Results</span>
		  <textarea class="form-control" data-toggle="tooltip" title="Specifically, what is this trial trying to improve?"><?php echo $commentGoal; ?></textarea>
		</div>

		<div class="trial-monitor form-group align-top">
		  <span class="elem-title">Aspects to Monitor</span>
		  <textarea class="form-control" data-toggle="tooltip" title="Specifically, what must be monitored on this trial?"><?php echo $commentMonitor; ?></textarea>
		</div>

	</div>



	<div class="row form-inline">

		<div class="trial-comment form-group">
		  <span class="elem-title">General Comments</span>
		  <textarea class="form-control" data-toggle="tooltip" title="Any miscellaneous comments about this trial."><?php echo $commentGeneral; ?></textarea>
		</div>

		<div class="trial-conclusion form-group">
		  <span class="elem-title">Conclusions (After Trial Completion)</span>
		  <textarea class="form-control" data-toggle="tooltip" title="What were the results of the trial? Was it successful? Should another trial be performed?"><?php echo $commentConclusion; ?></textarea>
		</div>

	</div>



</div>






<script type="text/javascript">
	$('#m-update-info .trial-unit select').val(<?php echo '"' . $unit . '"'; ?>);
	$('#m-update-info .trial-type select').val(<?php echo '"' . $trialType . '"'; ?>);
	$('#m-update-info .change-type select').val(<?php echo '"' . $changeType . '"'; ?>);
	$('#m-update-info .bop-vsl select').val(<?php echo '"' . $bopVsl . '"'; ?>);
	$('#m-update-info .degas-vsl select').val(<?php echo '"' . $degasVsl . '"'; ?>);
	$('#m-update-info .argon-num select').val(<?php echo '"' . $argonNum . '"'; ?>);
	$('#m-update-info .caster-num select').val(<?php echo '"' . $casterNum . '"'; ?>);
	$('#m-update-info .strand-num select').val(<?php echo '"' . $strandNum . '"'; ?>);

</script>





