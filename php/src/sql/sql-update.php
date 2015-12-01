<?php
	$trialSeq = json_decode($_POST["trialSeq"]);
	$trialInfo = json_decode($_POST["trialInfo"]);
	$trialHeatData = json_decode($_POST["trialHeatData"]);


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


	try {
		$conn->autocommit(FALSE);

		$sql = 
			"update trial \n" .
			"set  \n" .
			"  trial_name = " . $trialInfo->trialName . ", \n" .
			"  user = " . $trialInfo->owner . ", \n" .
			"  start_dt = " . $trialInfo->startDate . ", \n" .
			"  end_dt = " . $trialInfo->endDate . ", \n" .
			"  proc_chg_num = " . $trialInfo->processChange . ", \n" .
			"  twi_num = " . $trialInfo->twi . ", \n" .
			"  unit = " . $trialInfo->unit . ", \n" .
			"  trial_type = " . $trialInfo->trialType . ", \n" .
			"  change_type = " . $trialInfo->changeType . ", \n" .
			"  bop_vsl = " . $trialInfo->bopVsl . ", \n" .
			"  degas_vsl = " . $trialInfo->degasVsl . ", \n" .
			"  argon_station = " . $trialInfo->argonNum . ", \n" .
			"  caster_num = " . $trialInfo->casterNum . ", \n" .
			"  strand_num = " . $trialInfo->strandNum . ", \n" .
			"  comment_goal = " . $trialInfo->goalText . ", \n" .
			"  comment_monitor = " . $trialInfo->monitorText . ", \n" .
			"  comment_general = " . $trialInfo->otherInfoText . ", \n" .
			"  comment_conclusion = " . $trialInfo->conclusionText . " \n" .
			"where trial_seq = " . $trialSeq;

		$conn->query($sql);


		$sql =
			"delete from trial_ht \n" .
			"where trial_seq = " . $trialSeq;

		$conn->query($sql);


		if (count($trialHeatData) > 0) {
			if ($trialHeatData[0][0] !== "NULL") {
				$sql = 
			  	"insert into trial_ht ( \n" .
					"  trial_seq, ht_num, tap_yr, bop_vsl, degas_vsl, argon_num, caster_num, strand_num, comment \n" .
					") \n";

			  for ($i = 0; $i <= count($trialHeatData) - 1; $i++) {
			  	if ($i > 0) {
			  		$sql .= "union \n";
			  	}

			  	$sql .= 
			  		"select " .
						$trialSeq . ", " .
						$trialHeatData[$i][0] . ", " .
						$trialHeatData[$i][1] . ", " .
						$trialHeatData[$i][2] . ", " .
						$trialHeatData[$i][3] . ", " .
						$trialHeatData[$i][4] . ", " .
						$trialHeatData[$i][5] . ", " .
						$trialHeatData[$i][6] . ", " .
						$trialHeatData[$i][7] . " \n";			
			  }

			  $conn->query($sql);
			}
		}


		$conn->commit();
		$status = "success";
	} catch (Exception $e) {
		// An exception has been thrown
    // We must rollback the transaction
    $conn->rollback();
    $status = "failure";
  }


	$output = new stdClass();
	$output->status = $status;
	$output->trialSeq = $trialSeq;


	echo json_encode($output);

	$conn->close();
?>